<?php

namespace App\Livewire\Modals;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class LanguageModal extends Component
{

    public $selectedLanguage = "", $otherLanguage;
    public $languageError;

    #[Modelable]
    public $languages;

    public function addLanguage()
    {
        // Define validation rules for the main language input
        $rules = [
            'selectedLanguage' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Check if the selected language is already in the list
                    if (collect($this->languages)->contains('language', $value)) {
                        $fail("The language is already in the list.");
                    }
                },
            ],
        ];

        // Define custom validation messages for the main language input
        $messages = [
            'selectedLanguage.required' => 'The language is required.',
            'selectedLanguage.string' => 'The language must be a string.',
        ];

        // If the selected language is 'other', add additional validation rules for the 'otherLanguage' input
        if ($this->selectedLanguage === 'other') {
            $rules['otherLanguage'] = [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Check if the 'otherLanguage' value is already in the list
                    if (collect($this->languages)->contains('language', $value)) {
                        $fail("The language is already in the list.");
                    }
                },
            ];

            // Add custom validation message for 'otherLanguage'
            $messages['otherLanguage.required'] = 'The other language is required.';
            $messages['otherLanguage.string'] = 'The other language must be a string.';
        }

        // Perform validation
        $this->validate($rules, $messages);

        // If the selected language is 'other', add the 'otherLanguage' value to the languages array
        if ($this->selectedLanguage === 'other') {
            $languageToAdd = $this->otherLanguage;
        } else {
            $languageToAdd = $this->selectedLanguage;
        }

        // Add the language to the languages array with default values for other attributes
        $this->languages[] = [
            'language' => $languageToAdd,
            'read' => true,
            'write' => true,
            'speak' => true,
            'understand' => true,
        ];

        $this->dispatch('refreshLanguage');
        $this->close();

    }

    public function close()
    {
        $this->resetValidation();
        $this->dispatch('close-modal', 'language-modal');
        $this->reset('selectedLanguage', 'otherLanguage');
    }

    public function render()
    {
        return view('livewire.modals.language-modal');
    }
}
