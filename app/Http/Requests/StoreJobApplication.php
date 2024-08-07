<?php

namespace App\Http\Requests;

use App\Job;
use App\JobJobLocation;
use App\Question;
use Illuminate\Support\Arr;

class StoreJobApplication extends CoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $job = Job::find($this->job_id);

        if (!$job) {
            return [
                'full_name' => 'required|string|max:255',
                'email' => 'email|required|string|max:255',
                'phone' => 'numeric|required',
                'job_id' => 'required|exists:jobs,id',
                'annees_experience' => 'nullable|integer',
                'salaire_actuel' => 'nullable|numeric',
                'tj_actual' => 'nullable|numeric',
                'retention_salariale' => 'nullable|numeric',
                'tj_souhaite' => 'nullable|numeric',
                'disponibilite' => 'nullable|string|max:50',
                'cv' => 'nullable|mimes:pdf|max:2048',
                'niveau_etudes' => 'nullable|string|max:50',
                'competences' => 'nullable|string|max:255',
                'statut' => 'nullable|string|max:50',
            ];
        }

        $requiredColumns = $job->required_columns ?? [];
        $sectionVisibility = $job->section_visibility ?? [];

        $rules = [
            'full_name' => 'required|string|max:255',
                'email' => 'email|required|string|max:255',
                'phone' => 'numeric|required',
                'job_id' => 'required|exists:jobs,id',
                'annees_experience' => 'nullable|integer',
                'salaire_actuel' => 'nullable|numeric',
                'tj_actual' => 'nullable|numeric',
                'retention_salariale' => 'nullable|numeric',
                'tj_souhaite' => 'nullable|numeric',
                'disponibilite' => 'nullable|string|max:50',
                'cv' => 'nullable|mimes:pdf|max:2048',
                'niveau_etudes' => 'nullable|string|max:50',
                'competences' => 'nullable|string|max:255',
                'statut' => 'nullable|string|max:50',
        ];

        if (!empty($requiredColumns['gender'])) {
            $rules['gender'] = 'required|in:male,female,others';
        }
        if (!empty($requiredColumns['dob'])) {
            $rules['dob'] = 'required|date';
        }
        if (!empty($requiredColumns['country'])) {
            $rules['country'] = 'required|integer|min:1';
            $rules['state'] = 'required|integer|min:1';
            $rules['city'] = 'required|string|max:255';
        }

        foreach ($sectionVisibility as $key => $section) {
            if ($section === 'yes') {
                if ($key === 'profile_image') {
                    $rules['photo'] = 'required|mimes:jpeg,jpg,png|max:2048';
                }
                if ($key === 'resume') {
                    $rules['resume'] = 'required|mimes:jpeg,jpg,png,doc,docx,rtf,xls,xlsx,pdf|max:2048';
                }
            }
        }

        $answers = $this->get('answer');
        if (!empty($answers)) {
            foreach ($answers as $key => $value) {
                $answer = Question::find($key);
                if ($answer && $answer->required === 'yes') {
                    $rules["answer.{$key}"] = 'required|string|max:255';
                }
            }
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'answer.*.required' => 'This answer field is required.',
            'dob.required' => 'Date of Birth field is required.',
            'country.min' => 'Please select a valid country.',
            'state.min' => 'Please select a valid state.',
            'city.required' => 'Please enter a city.',
        ];
    }
}
