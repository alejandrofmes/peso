<?php

namespace App\Livewire\Modals;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class TrainingModal extends Component
{
    public $trainName, $trainStart, $trainEnd, $trainInstitution, $trainCert, $trainStat;
    public $editIndex = null;

    #[Modelable]
    public $trainingData = [];

    public function save()
    {
        $rules = [
            'trainName' => 'required|string|max:255',
            'trainStart' => [
                'required',
                'date',
                'before_or_equal:today', // Ensure eduStart is not in the future
            ],
            'trainEnd' => [
                'nullable',
                'date',
                'before_or_equal:today', // Ensure eduEnd is not in the future
                'after:trainStart', // Ensure eduEnd is after or equal to eduStart
            ],
            'trainInstitution' => 'required|string|max:255',
            'trainCert' => 'required|string|max:255',
            'trainStat' => 'required|in:1,2,3',
        ];

        $messages = [
            'trainName.required' => 'The training name is required.',
            'trainName.string' => 'The training name must be a string.',
            'trainName.max' => 'The training name must not exceed 255 characters.',
            'trainStart.required' => 'The start date of the training is required.',
            'trainStart.date' => 'The start date must be a valid date.',
            'trainStart.before_or_equal' => 'The start date must be before or equal to today.',
            'trainEnd.date' => 'The end date must be a valid date.',
            'trainEnd.before_or_equal' => 'The end date must be before or equal to today.',
            'trainEnd.after' => 'The end date must be after the start date.',
            'trainInstitution.required' => 'The institution of the training is required.',
            'trainInstitution.string' => 'The institution must be a string.',
            'trainInstitution.max' => 'The institution must not exceed 255 characters.',
            'trainCert.required' => 'The certification of the training is required.',
            'trainCert.string' => 'The certification must be a string.',
            'trainCert.max' => 'The certification must not exceed 255 characters.',
            'trainStat.required' => 'The status of the training is required.',
            'trainStat.in' => 'The status must be one of the following: 1, 2, 3.',
        ];

        $this->validate($rules, $messages);

        $trainingData = [
            'trainName' => $this->trainName,
            'trainStart' => $this->trainStart,
            'trainEnd' => $this->trainEnd,
            'trainInstitution' => $this->trainInstitution,
            'trainCert' => $this->trainCert,
            'trainStat' => $this->trainStat,
        ];

        if ($this->editIndex !== null) {
            $this->trainingData[$this->editIndex] = $trainingData;
            toastr()->success('Record Updated!');
        } else {
            $this->trainingData[] = $trainingData;
            toastr()->success('Record added!');
        }

        $this->dispatch('refreshCertTrain');
        $this->close();

    }

    #[On('editTraining')]
    public function editTraining($index)
    {
        $this->trainName = $this->trainingData[$index]['trainName'];
        $this->trainStart = $this->trainingData[$index]['trainStart'];
        $this->trainEnd = $this->trainingData[$index]['trainEnd'];
        $this->trainInstitution = $this->trainingData[$index]['trainInstitution'];
        $this->trainCert = $this->trainingData[$index]['trainCert'];
        $this->trainStat = $this->trainingData[$index]['trainStat'];
        $this->editIndex = $index;
        $this->dispatch('open-modal', 'training-modal');
    }

    public function close()
    {
        $this->resetValidation();
        $this->reset('trainName', 'trainStart', 'trainEnd', 'trainInstitution', 'trainCert', 'trainStat', 'editIndex');
        $this->dispatch('close-modal', 'training-modal');
    }

    public function render()
    {
        return view('livewire.modals.training-modal');
    }
}
