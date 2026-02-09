require('dotenv').config();
const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');
const nodemailer = require('nodemailer');
const fs = require('fs');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 3000;
const DB_FILE = path.join(__dirname, 'db.json');

// Allow all origins for simplicity in free hosting deployment
app.use(cors());
app.use(bodyParser.json());

// Persistent "Database" initialization
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

// Cleanup expired bookings periodically (Checking every 10 seconds for robustness)
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
}, 10000); // Check every 10 seconds

// Email Transporter (StartTLS for better compatibility on free hosting)
const transporter = nodemailer.createTransport({
    host: 'smtp.gmail.com',
    port: 587,
    secure: false, // Use STARTTLS
    auth: {
        user: process.env.EMAIL_USER,
        pass: process.env.EMAIL_PASS
    },
    tls: {
        rejectUnauthorized: false
    }
});

// Verify transporter connection
transporter.verify((error, success) => {
    if (error) {
        console.error("Transporter connection error:", error);
    } else {
        console.log("Mail server is ready to send messages");
    }
});

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

    const mailOptions = {
        from: `"ParkOur System" <${process.env.EMAIL_USER}>`,
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
    };

    try {
        await transporter.sendMail(mailOptions);
        console.log(`Booking email sent to ${email}`);
    } catch (e) {
        console.error("Mail failed for booking:", e.message);
    }

    res.json({ success: true, message: 'Booking confirmed' });
});

app.post('/api/contact', async (req, res) => {
    const { name, email, subject, message } = req.body;
    console.log(`ParkOur Contact Request: ${name} (${email})`);

    const mailOptions = {
        from: `"ParkOur Contact" <${process.env.EMAIL_USER}>`, // Sent FROM our authenticated email
        to: process.env.EMAIL_USER, // Send TO the site owner
        replyTo: email, // Set Reply-To as the user's email
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
    };

    try {
        await transporter.sendMail(mailOptions);
        console.log("Contact email sent successfully.");
        res.json({ success: true, message: 'Message received' });
    } catch (e) {
        console.error("Contact mail failed to send:", e.message);
        res.status(500).json({ success: false, message: 'Failed to send message', error: e.message });
    }
});

app.listen(PORT, () => {
    console.log(`ParkOur Backend running on port ${PORT}`);
});
