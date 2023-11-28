<?php

namespace Tests\Feature;

use App\Http\Livewire\ContactForm;
use App\Mail\ContactFormMailable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    /** @test */
    public function contactFormComponentExists()
    {
        $this->get('/')
            ->assertSeeLivewire('contact-form');
    }

    /** @test */
    public function contactFormSubmission()
    {
        Mail::fake();

        Livewire::test(ContactForm::class)
            ->set('name', 'Alex')
            ->set('email', 'alex@alex.com')
            ->set('phone', '0787321744')
            ->set('message', 'A message')
            ->assertSee('We received your message successfully and will get back to you shortly!');

        Mail::assertSent('contact', function(ContactFormMailable $mail) {
            $mail->build();

            return $mail->hasTo('andre@andre.com') &&
                $mail->hasFrom('you@you.com') &&
                $mail->subject === 'Contact Form Submission';
        });
    }
}
