import { Component, signal, computed, inject, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { FormsModule } from '@angular/forms';

import { environment } from '../../../environments/environment';

interface Slot {
  id: number;
  isAvailable: boolean;
  bookedUntil: string | null;
}

@Component({
  selector: 'app-booking',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './booking.component.html',
  styleUrl: './booking.component.scss'
})
export class BookingComponent implements OnInit {
  private http = inject(HttpClient);
  private apiUrl = environment.apiUrl;

  slots = signal<Slot[]>([]);
  selectedSlot = signal<Slot | null>(null);
  duration = signal<number>(30);
  durationValue = 30;
  email = '';
  isProcessing = signal(false);
  showSuccess = signal(false);
  lastBookedId = 0;

  totalPrice = computed(() => (this.duration() / 30) * 10);

  ngOnInit() {
    this.fetchSlots();
  }

  fetchSlots() {
    this.http.get<Slot[]>(`${this.apiUrl}/availability`).subscribe(data => {
      this.slots.set(data);
    });
  }

  selectSlot(slot: Slot) {
    if (slot.isAvailable) {
      this.selectedSlot.set(slot);
      this.showSuccess.set(false);
    }
  }

  updateDuration(event: any) {
    this.duration.set(parseInt(event.target.value));
  }

  confirmBooking() {
    if (!this.email || !this.email.includes('@')) {
      alert('Please enter a valid email for confirmation.');
      return;
    }

    this.isProcessing.set(true);
    const bookingData = {
      slotId: this.selectedSlot()?.id,
      duration: this.duration(),
      email: this.email,
      amount: this.totalPrice()
    };

    // Simulate "Paying" delay as requested by the user
    setTimeout(() => {
      this.http.post(`${this.apiUrl}/bookings`, bookingData).subscribe({
        next: (res: any) => {
          this.lastBookedId = bookingData.slotId!;
          this.showSuccess.set(true);
          this.fetchSlots();
          this.selectedSlot.set(null);
          this.isProcessing.set(false);
        },
        error: () => {
          alert('Booking failed. Please check backend connection.');
          this.isProcessing.set(false);
        }
      });
    }, 2500); // 2.5 second delay to fill the gap
  }

  reset() {
    this.showSuccess.set(false);
    this.email = '';
    this.durationValue = 30;
    this.duration.set(30);
  }
}
