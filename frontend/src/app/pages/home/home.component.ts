import { Component, signal, inject, OnInit } from '@angular/core';
import { RouterLink } from '@angular/router';
import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';

import { environment } from '../../../environments/environment';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './home.component.html',
  styleUrl: './home.component.scss'
})
export class HomeComponent implements OnInit {
  private http = inject(HttpClient);
  stats = signal({ total: 20, available: 0 });

  ngOnInit() {
    this.http.get<any[]>(`${environment.apiUrl}/availability`).subscribe(slots => {
      this.stats.set({
        total: slots.length,
        available: slots.filter(s => s.isAvailable).length
      });
    });
  }
}
