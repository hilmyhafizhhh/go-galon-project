{{-- <style>
    #preview-image {
        width: 7rem;            /* default (w-28) */
        height: 7rem;           /* default (h-28) */
        border-radius: 9999px;  /* rounded-full */
        object-fit: cover;      /* gambar tetap proporsional */
        object-position: center;
        transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
    }

    /* ✅ Responsive adjustment (biar pas di HP) */
    @media (max-width: 640px) { /* sm breakpoint Tailwind */
        #preview-image {
            width: 5.5rem;  /* sedikit lebih kecil di HP */
            height: 5.5rem;
        }
    }

    /* ✅ Tambahan efek hover lembut */
    #preview-image:hover {
        transform: scale(1.02);
    }
</style> --}}

<section class="p-4 sm:p-6 lg:p-8 bg-white rounded-xl shadow-sm">
    <header>
        <h2 class="text-lg font-semibold text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information, including your photo, name, username, and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- ======================= FORM START ======================= --}}
    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- ======== FOTO PROFIL ======== --}}
        {{-- <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 sm:gap-8">
            <div class="relative flex-shrink-0">
                <img 
                    id="preview-image" 
                    src="{{ $user->profile_image 
                        ? asset('storage/profile_images/' . $user->profile_image) 
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=4F46E5&color=fff' }}"
                    alt="Profile Photo"
                    class="border-4 border-indigo-100 shadow-sm"
                />
            </div>

            <div class="w-full max-w-xs sm:max-w-md">
                <x-input-label for="profile_image" :value="__('Profile Photo')" />
                <input 
                    id="profile_image" 
                    name="profile_image" 
                    type="file" 
                    accept="image/*" 
                    class="mt-1 block w-full text-sm text-gray-700
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-md file:border-0
                           file:text-sm file:font-semibold
                           file:bg-indigo-50 file:text-indigo-700
                           hover:file:bg-indigo-100"
                    onchange="previewImage(event)"
                />
                <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />

                <p class="text-xs text-gray-500 mt-1">Max size 2MB. Format: JPG, PNG.</p>
            </div>
        </div> --}}

        {{-- ======== NAME ======== --}}
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" name="name" type="text" 
                class="mt-1 block w-full" 
                :value="old('name', $user->name)" 
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- ======== USERNAME ======== --}}
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text"
                class="mt-1 block w-full"
                :value="old('username', $user->username)" 
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        {{-- ======== EMAIL ======== --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" 
                class="mt-1 block w-full" 
                :value="old('email', $user->email)" 
                required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- ======== BUTTON SAVE ======== --}}
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Changes') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

{{-- Script Preview Foto --}}
{{-- <script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('preview-image');
            output.style.opacity = 0;
            output.src = reader.result;
            setTimeout(() => output.style.opacity = 1, 150);
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script> --}}
