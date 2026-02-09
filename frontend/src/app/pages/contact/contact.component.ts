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
  errors = signal<any>({});

  validateForm(): boolean {
    const errors: any = {};
    let isValid = true;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!this.form.name || this.form.name.length < 2) {
      errors.name = 'Name must be at least 2 characters.';
      isValid = false;
    }

    if (!this.form.email || !emailRegex.test(this.form.email)) {
      errors.email = 'Please enter a valid email address.';
      isValid = false;
    }

    if (!this.form.subject || this.form.subject.length < 5) {
      errors.subject = 'Subject must be at least 5 characters.';
      isValid = false;
    }

    if (!this.form.message || this.form.message.length < 10) {
      errors.message = 'Message must be at least 10 characters.';
      isValid = false;
    }

    this.errors.set(errors);
    return isValid;
  }

  sendMessage() {
    if (!this.validateForm()) {
      return;
    }

    this.isSending.set(true);
    this.http.post(`${this.apiUrl}/contact`, this.form).subscribe({
      next: () => {
        this.isSending.set(false);
        this.showSuccess.set(true);
        this.errors.set({});
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
