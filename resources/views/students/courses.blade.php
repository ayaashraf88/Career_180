@extends('components.layouts.app')
@section('content')
<div class="container">

    <h2 class="mb-4">My Enrolled Courses</h2>
    <div x-data="{open:false}">
        <button @click="open = !open" class="btn btn-primary mb-3">Toggle Search</button>
        <div x-show="open" class="mb-3">
            <select name="" id="" @click.outside="open = false">
                <option value="">Select Course</option>

            </select>

        </div>
        <div x-data="{modalOpen :false}">
            <div>
                <button class="btn btn-primary" @click="modalOpen = !modalOpen">Open Modal 1</button>
                <!-- <button class="btn btn-primary" @click="modalOpen = !modalOpen">Open Modal 2</button> -->
            </div>

            <div
                x-show="modalOpen"
                x-trap.noscroll="modalOpen"
                @keydown.escape.window="modalOpen = false"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="relative w-full max-w-lg bg-white p-8 rounded-xl shadow-2xl">
                <div>
                    <div class="bg-white p-6 rounded shadow-lg">
                        <h2 class="text-xl font-bold mb-4">Modal Title</h2>
                        <p class="mb-4">This is the content of the modal.</p>
                    </div>
                </div>
                <button @click="modalOpen = false" class="px-4 py-2 bg-gray-200 rounded">
                    Close
                </button>

            </div>

        </div>
        <div x-data="{activeTabs:$persist('tab1')}" class="w-full">
            <div class="flex">
                <button :class="activeTabs === 'tab1' ? 'bg-blue-500 text-white' : 'bg-gray-200'" @click="activeTabs = 'tab1'">tab1</button>
                <button :class="activeTabs === 'tab2' ? 'bg-blue-500 text-white' : 'bg-gray-200'" @click="activeTabs = 'tab2'">tab2</button>
            </div>
            <div>
                <div x-show="activeTabs === 'tab1'">
                    <p>This is the content of Tab 1.</p>
                </div>
                <div x-show="activeTabs === 'tab2'">
                    <p>This is the content of Tab 2.</p>
                </div>
            </div>

        </div>
        <div x-data="{email :'',username:'',isEmailValid(){return /^\S+@\S+\.\S+$/.test(this.email);}}" class="mb-4">
            <form @submit.prevent="alert(`Email: ${email}, Username: ${username}`)" class="space-y-4">
                <div>
                    <label for="search">Email:</label>
                    <input type="text" id="search" name="email" x-model="email" class="form-control"
                        placeholder="Enter course name"
                        :class="email && !isEmailValid() ? 'border-red-500' : 'border-gray-300'">
                    <span x-show="email&&!isEmailValid()"></span>
                </div>
                <div>
                    <label for="">username</label>
                    <input type="username" class="form-control" x-model="username" />
                </div>
                <button
                    type="submit"
                    :disabled="!isEmailValid() || username.length < 3"
                    :class="(!isEmailValid() || username.length < 3) ? 'bg-gray-400' : 'bg-blue-600'"
                    class="px-4 py-2 rounded">
                    Register
                </button>
            </form>
        </div>
        <div x-data="formWizard()" class="max-w-md mx-auto p-6 bg-white shadow rounded">
    <div class="flex mb-8 space-x-4">
        <template x-for="step in totalSteps">
            <div :class="currentStep >= step ? 'bg-blue-600' : 'bg-gray-200'" 
                 class="h-2 flex-1 rounded-full transition-colors duration-500">
            </div>
        </template>
    </div>

    <form @submit.prevent="submitForm">
        <div x-show="currentStep === 1" x-transition>
            <h2 class="text-xl font-bold mb-4">Account Details</h2>
            <input type="text" x-model="formData.name" placeholder="Full Name" class="border p-2 w-full">
            <p x-show="errors.name" x-text="errors.name" class="text-red-500 text-sm"></p>
        </div>

        <div x-show="currentStep === 2" x-transition>
            <h2 class="text-xl font-bold mb-4">Preferences</h2>
            <select x-model="formData.theme" class="border p-2 w-full">
                <option value="">Select Theme</option>
                <option value="dark">Dark</option>
                <option value="light">Light</option>
            </select>
            <p x-show="errors.theme" x-text="errors.theme" class="text-red-500 text-sm"></p>
        </div>

        <div class="mt-6 flex justify-between">
            <button type="button" x-show="currentStep > 1" @click="currentStep--" 
                    class="bg-gray-500 text-white px-4 py-2 rounded">
                Previous
            </button>
            
            <button type="button" x-show="currentStep < totalSteps" @click="nextStep" 
                    class="bg-blue-600 text-white px-4 py-2 rounded">
                Next
            </button>

            <button type="submit" x-show="currentStep === totalSteps" 
                    class="bg-green-600 text-white px-4 py-2 rounded">
                Confirm & Submit
            </button>
        </div>
    </form>
</div>
        @if($enrolledCourses)
        @livewire('search', [$enrolledCourses])
        @livewire('tweet')
        @else
        <p>You are not enrolled in any courses yet.</p>
        @endif


    </div>
    <script>
        function formWizard() {
    return {
        currentStep: 1,
        totalSteps: 2,
        formData: {
            name: '',
            theme: ''
        },
        errors: {
            name: '',
            theme: ''
        },
        
        validateStep() {
            // Clear previous errors
            this.errors = { name: '', theme: '' };

            if (this.currentStep === 1) {
                if (!this.formData.name) {
                    this.errors.name = "Name is required.";
                    return false;
                }
            }
            
            if (this.currentStep === 2) {
                if (!this.formData.theme) {
                    this.errors.theme = "Please pick a theme.";
                    return false;
                }
            }

            return true;
        },

        nextStep() {
            if (this.validateStep()) {
                this.currentStep++;
            }
        },

        submitForm() {
            if (this.validateStep()) {
                console.log('Submitting:', this.formData);
                alert('Success!');
            }
        }
    }
}
    </script>
    @endsection