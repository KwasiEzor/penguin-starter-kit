import "./libs/trix";
import './bootstrap';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import focus from '@alpinejs/focus';
import collapse from '@alpinejs/collapse';

Alpine.plugin(focus);
Alpine.plugin(collapse);

Alpine.data('accordion', (initialActive = null, multiple = false) => ({
    multiple: multiple,
    selected: multiple ? (initialActive ? [initialActive] : []) : initialActive,
    toggle(id) {
        if (this.multiple) {
            if (this.selected.includes(id)) {
                this.selected = this.selected.filter(function(i) { return i !== id; });
            } else {
                this.selected = [...this.selected, id];
            }
        } else {
            this.selected = (this.selected === id) ? null : id;
        }
    },
    isSelected(id) {
        return this.multiple ? this.selected.includes(id) : this.selected === id;
    }
}));

Livewire.start();
