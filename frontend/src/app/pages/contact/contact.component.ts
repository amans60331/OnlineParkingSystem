import { Component, signal, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { HttpClient } from '@angular/common/http';

import { environment } from '../../../environments/environment';

@Component({
  selector: 'app-contact',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './contact.component.html',
  styleUrl: './contact.component.scss'
})
export class ContactComponent {
  private http = inject(HttpClient);
  private apiUrl = environment.apiUrl;

  form = { name: '', email: '', subject: '', message: '' };
  isSending = signal(false);
  showSuccess = signal(false);

  sendMessage() {
    this.isSending.set(true);
    this.http.post(`${this.apiUrl}/contact`, this.form).subscribe({
      next: () => {
        this.isSending.set(false);
        this.showSuccess.set(true);
      },
      error: () => {
        alert('Failed to send message. Please check the backend connection.');
        this.isSending.set(false);
      }
    });
  }

  resetForm() {
    this.showSuccess.set(false);
    this.form = { name: '', email: '', subject: '', message: '' };
  }
}
