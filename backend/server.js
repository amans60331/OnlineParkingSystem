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

// Email Transporter (Use environment variables for production)
const transporter = nodemailer.createTransport({
    service: 'gmail', // Use Gmail service or configured host
    auth: {
        user: process.env.EMAIL_USER || 'your-email@gmail.com', // Replace with Env Var
        pass: process.env.EMAIL_PASS || 'your-app-password'     // Replace with Env Var
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
        from: '"ParkOur System" <no-reply@parkour.com>',
        to: email,
        subject: "Booking Success - Bay #" + slotId,
        html: `
            <div style="font-family: sans-serif; padding: 20px; background: #0f172a; color: white;">
                <h1 style="color: #06b6d4;">ParkOur Confirmation</h1>
                <p>Your reservation for <b>Bay #${slotId}</b> is confirmed.</p>
                <hr style="border: 0; border-top: 1px solid #1e293b;">
                <p><b>Duration:</b> ${duration} Minutes</p>
                <p><b>Amount Paid:</b> ${amount}rs</p>
                <p>Enjoy your hassle-free parking!</p>
            </div>
        `
    };

    try {
        await transporter.sendMail(mailOptions);
    } catch (e) { console.error("Mail failed", e); }

    res.json({ success: true, message: 'Booking confirmed' });
});

app.post('/api/contact', async (req, res) => {
    const { name, email, message } = req.body;
    console.log(`ParkOur Contact: ${name} (${email}) - ${message}`);

    const mailOptions = {
        from: `"${name}" <${email}>`, // Sent "from" the user's name
        to: process.env.EMAIL_USER, // Send TO the site owner (you)
        subject: `New Contact Message: ${req.body.subject}`, // Email Subject
        replyTo: email,
        html: `
            <div style="font-family: sans-serif; padding: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px;">
                <h2 style="color: #2f855a;">New Inquiry for ParkOur</h2>
                <p><strong>Name:</strong> ${name}</p>
                <p><strong>Email:</strong> ${email}</p>
                <p><strong>Subject:</strong> ${req.body.subject}</p>
                <hr style="border: 0; border-top: 1px solid #cbd5e1; margin: 20px 0;">
                <p style="white-space: pre-wrap;">${message}</p>
            </div>
        `
    };

    try {
        await transporter.sendMail(mailOptions);
        console.log("Contact email sent successfully.");
    } catch (e) {
        console.error("Contact mail failed to send:", e);
        // We still return success to frontend to show the user "Message Sent" as we logged it
    }

    res.json({ success: true, message: 'Message received' });
});

app.listen(PORT, () => {
    console.log(`ParkOur Backend running on port ${PORT}`);
});
