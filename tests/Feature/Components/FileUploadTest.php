<?php

it('renders the file upload component with default label', function (): void {
    $view = $this->blade('<x-file-upload wire="avatar" />');

    $view->assertSee('Upload a file');
    $view->assertSee('PNG, JPG, GIF up to 2MB');
});

it('renders with custom label and hint', function (): void {
    $view = $this->blade('<x-file-upload wire="image" label="Upload photo" hint="Max 5MB" />');

    $view->assertSee('Upload photo');
    $view->assertSee('Max 5MB');
});

it('renders preview image when provided', function (): void {
    $view = $this->blade('<x-file-upload preview="/img/test.jpg" />');

    $view->assertSee('src="/img/test.jpg"', false);
});

it('renders remove button when removable with preview', function (): void {
    $view = $this->blade('<x-file-upload preview="/img/test.jpg" :removable="true" removeAction="removeImage" />');

    $view->assertSee('removeImage');
});
