@props([
    'active' => null, // ID of the initially active item
    'multiple' => false, // Allow multiple items to be open at once
])

<div 
    x-data="{ 
        active: @json($active),
        multiple: @json($multiple),
        selected: @json($multiple ? [$active] : $active),
        toggle(id) {
            if (this.multiple) {
                if (this.selected.includes(id)) {
                    this.selected = this.selected.filter(i => i !== id);
                } else {
                    this.selected.push(id);
                }
            } else {
                this.selected = (this.selected === id) ? null : id;
            }
        },
        isSelected(id) {
            return this.multiple ? this.selected.includes(id) : this.selected === id;
        }
    }" 
    {{ $attributes->merge(['class' => 'space-y-2']) }}
>
    {{ $slot }}
</div>
