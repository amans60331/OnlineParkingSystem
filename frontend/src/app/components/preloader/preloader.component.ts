import { Component, signal, OnInit, Output, EventEmitter } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-preloader',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './preloader.component.html',
  styleUrl: './preloader.component.scss'
})
export class PreloaderComponent implements OnInit {
  progress = signal(0);
  isFinished = signal(false);
  statusMessage = signal('Loading Modules');

  @Output() completed = new EventEmitter<void>();

  private messages = [
    'Initializing Engine',
    'Syncing Satellite Data',
    'Mapping Parking Grid',
    'Securing Interface',
    'Ready for Launch'
  ];

  ngOnInit() {
    const interval = setInterval(() => {
      this.progress.update(p => {
        const msgIdx = Math.floor((p / 100) * this.messages.length);
        this.statusMessage.set(this.messages[msgIdx] || 'System Ready');

        if (p >= 100) {
          clearInterval(interval);
          setTimeout(() => {
            this.isFinished.set(true);
            this.completed.emit();
          }, 800);
          return 100;
        }
        return p + 2;
      });
    }, 45);
  }
}
