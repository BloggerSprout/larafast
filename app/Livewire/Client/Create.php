<?php

namespace App\Livewire\Client;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use PgSql\Lob;

class Create extends Component
{
    use LivewireAlert; // Use this trait for SweetAlerts

    public $first_name;
    public $last_name;
    public $email;
    public $mobile_no;
    public $street_address;
    public $city;
    public $region;
    public $postal_code;
    public $status = true;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:clients',
        'mobile_no' => 'required|numeric',
        'street_address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'region' => 'required|string|max:255',
        'postal_code' => 'required|numeric',
        'status' => 'required|boolean',
    ];

    public function store(Request $request)
    {
            // Validate the input data based on the defined rules
        $validatedData = $this->validate();
        Log::info($validatedData);
        // Create a new client with the validated data
        Client::create($validatedData);

        // Reset form fields
        $this->reset(['first_name', 'last_name', 'email', 'mobile_no', 'street_address', 'city', 'region', 'postal_code']);

        // Use this for SweetAlerts
        $this->alert('success', __('Client successfully created'), [
            'toast' => false,
            'position' => 'center',
            'timer' => 2000, // Optional: Set timer for auto-dismissal
        ]);

        // Redirect after showing the alert
        return redirect()->to('/clients');
    }

    public function render()
    {
        return view('livewire.client.create');
    }
}