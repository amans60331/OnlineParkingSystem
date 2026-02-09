require('dotenv').config();
const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');
const fs = require('fs');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 3000;
const DB_FILE = path.join(__dirname, 'db.json');

// CORS - Allow all origins
app.use(cors());
app.use(bodyParser.json());

// ==================== DATABASE ====================
let db = {
    slots: Array.from({ length: 20 }, (_, i) => ({
        id: i + 1,
        isAvailable: true,
        bookedUntil: null
    }))
};

const loadDB = () => {
    if (fs.existsSync(DB_FILE)) {
        try {
            const data = fs.readFileSync(DB_FILE);
            db = JSON.parse(data);
        } catch (err) {
            console.error("Error reading DB file:", err);
        }
    }
};

const saveDB = () => {
    try {
        fs.writeFileSync(DB_FILE, JSON.stringify(db, null, 2));
    } catch (err) {
        console.error("Error writing DB file:", err);
    }
};

loadDB();

// Cleanup expired bookings periodically
setInterval(() => {
    const now = new Date().getTime();
    let changed = false;
    db.slots.forEach(slot => {
        if (!slot.isAvailable && slot.bookedUntil) {
            const expiryTime = new Date(slot.bookedUntil).getTime();
            if (expiryTime < now) {
                console.log(`Slot ${slot.id} expired. Making available.`);
                slot.isAvailable = true;
                slot.bookedUntil = null;
                changed = true;
            }
        }
    });
    if (changed) saveDB();
}, 10000);

// ==================== EMAIL (Resend API - works over HTTPS) ====================
async function sendEmail({ to, subject, html }) {
    const RESEND_API_KEY = process.env.RESEND_API_KEY;
    if (!RESEND_API_KEY) {
        console.warn("RESEND_API_KEY not set. Skipping email.");
        return { success: false, error: "No API key" };
    }

    try {
        const response = await fetch('https://api.resend.com/emails', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${RESEND_API_KEY}`,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                from: 'ParkOur <onboarding@resend.dev>',
                to: [to],
                subject: subject,
                html: html
            })
        });

        const data = await response.json();
        if (response.ok) {
            console.log(`Email sent to ${to}:`, data.id);
            return { success: true, id: data.id };
        } else {
            console.error("Resend API error:", data);
            return { success: false, error: data };
        }
    } catch (err) {
        console.error("Email send error:", err.message);
        return { success: false, error: err.message };
    }
}

// ==================== ROUTES ====================
app.get('/api/availability', (req, res) => {
    res.json(db.slots);
});

app.post('/api/bookings', async (req, res) => {
    const { slotId, duration, email, amount } = req.body;

    const slot = db.slots.find(s => s.id === slotId);
    if (!slot || !slot.isAvailable) {
        return res.status(400).json({ message: 'Slot not available' });
    }

    slot.isAvailable = false;
    slot.bookedUntil = new Date(Date.now() + duration * 60000);
    saveDB();

    // Send email (non-blocking, don't fail the booking if email fails)
    sendEmail({
        to: email,
        subject: "Booking Success - Bay #" + slotId,
        html: `
            <div style="font-family: sans-serif; padding: 20px; background: #0f172a; color: white; border-radius: 10px;">
                <h1 style="color: #48bb78;">ParkOur Confirmation</h1>
                <p>Your reservation for <b>Bay #${slotId}</b> is confirmed.</p>
                <hr style="border: 0; border-top: 1px solid #1e293b; margin: 20px 0;">
                <p><b>Duration:</b> ${duration} Minutes</p>
                <p><b>Amount Paid:</b> ${amount}rs</p>
                <p>Enjoy your hassle-free parking!</p>
            </div>
        `
    });

    res.json({ success: true, message: 'Booking confirmed' });
});

app.post('/api/contact', async (req, res) => {
    const { name, email, subject, message } = req.body;
    console.log(`ParkOur Contact Request: ${name} (${email})`);

    const ownerEmail = process.env.OWNER_EMAIL || 'amans60331@gmail.com';

    const result = await sendEmail({
        to: ownerEmail,
        subject: `New Contact Message: ${subject || 'No Subject'}`,
        html: `
            <div style="font-family: 'Outfit', sans-serif; padding: 30px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 20px; color: #2d3748;">
                <h2 style="color: #2f855a; margin-top: 0;">New Inquiry for ParkOur</h2>
                <div style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                    <p><strong>From:</strong> ${name} &lt;${email}&gt;</p>
                    <p><strong>Subject:</strong> ${subject || 'N/A'}</p>
                </div>
                <hr style="border: 0; border-top: 1px solid #cbd5e1; margin: 20px 0;">
                <p style="white-space: pre-wrap; line-height: 1.6;">${message}</p>
            </div>
        `
    });

    if (result.success) {
        res.json({ success: true, message: 'Message received' });
    } else {
        res.status(500).json({ success: false, message: 'Failed to send message' });
    }
});

app.listen(PORT, () => {
    console.log(`ParkOur Backend running on port ${PORT}`);
});
