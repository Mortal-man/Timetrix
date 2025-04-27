@extends('layouts.app')

@section('content')
    <style>
        body {
            background: #181818; /* Dark background */
            color: white; /* White text for contrast */
        }
        .profile-container {
            max-width: 800px;
            margin: 3rem auto;
            background: #2d2d2d;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .back-btn {
            background: #4f46e5;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 2rem;
        }
        .back-btn:hover {
            background: #4338ca;
        }
        .profile-title {
            font-size: 2rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .input-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #e5e7eb;
            font-weight: 600;
        }
        input, .file-input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #4b5563;
            border-radius: 8px;
            font-size: 1rem;
            background: #4b5563;
            color: white;
            transition: border-color 0.3s;
        }
        input:focus, .file-input:focus {
            border-color: #4f46e5;
            background: #fff;
            outline: none;
            color: #111827;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
        }
        .save-btn, .delete-btn {
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
        }
        .save-btn {
            background-color: #4f46e5;
            color: white;
        }
        .save-btn:hover {
            background-color: #4338ca;
        }
        .delete-btn {
            background-color: #ef4444;
            color: white;
        }
        .delete-btn:hover {
            background-color: #dc2626;
        }
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            inset: 0;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 0.3s ease-in-out;
        }
        .modal-actions {
            display: flex;
            justify-content: space-around;
            margin-top: 1rem;
        }
        .modal-btn {
            padding: 0.6rem 1.2rem;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .cancel-btn {
            background-color: #9ca3af;
            color: white;
        }
        .confirm-btn {
            background-color: #ef4444;
            color: white;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        .alert {
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
        }
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .current-avatar {
            display: block;
            max-width: 120px;
            max-height: 120px;
            border-radius: 50%;
            margin-bottom: 1rem;
            object-fit: cover;
        }
        .current-avatar, #preview-avatar {
            display: block;
            max-width: 120px;
            max-height: 120px;
            border-radius: 50%;
            margin-bottom: 1rem;
            object-fit: cover;
        }
        #preview-avatar {
            display: none; /* hidden until a file is picked */
        }
    </style>

    <div class="profile-container">
        {{-- Back button --}}
        <a href="{{ route('dashboard') }}" class="back-btn">&larr; Back to Dashboard</a>

        {{-- Flash Success --}}
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        {{-- Password Verified --}}
        @if (session('password_verified'))
            <div class="alert alert-success">
                Password successfully verified ✅
            </div>
        @endif

        <h2 class="profile-title">Manage Your Profile</h2>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- Name --}}
            <div class="input-group">
                <label for="name">Name</label>
                <input id="name" name="name" type="text"
                       value="{{ old('name', $user->name) }}"
                       required autofocus
                       pattern="[A-Za-z\s]+"
                       title="Only letters and spaces are allowed.">
                @error('name')
                <p style="color: red; font-size: 0.875rem;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="input-group">
                <label for="email">Email Address</label>
                <input id="email" name="email" type="email"
                       value="{{ old('email', $user->email) }}"
                       required>
                @error('email')
                <p style="color: red; font-size: 0.875rem;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Change Password --}}
            <hr style="margin: 2rem 0;">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem;">Change Password</h3>

            <div class="input-group" id="currentPasswordSection">
                <label for="current_password">Enter Current Password to Continue</label>
                <input id="current_password" name="current_password" type="password">
                <button type="button"
                        onclick="validateCurrentPassword()"
                        style="margin-top: 1rem;"
                        class="save-btn">
                    Verify Password
                </button>
            </div>

            <div id="newPasswordSection" style="display: none;">
                <div class="input-group">
                    <label for="new_password">New Password</label>
                    <input id="new_password" name="new_password" type="password">
                    @error('new_password')
                    <p style="color: red; font-size: 0.875rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="new_password_confirmation">Confirm New Password</label>
                    <input id="new_password_confirmation"
                           name="new_password_confirmation"
                           type="password">
                </div>
            </div>

            {{-- Profile Picture (NEW) --}}
            <hr style="margin: 2rem 0;">
            <div class="input-group">
                <label for="profile_picture">Profile Picture</label>
                @if($user->profile_picture)
                    <img src="{{ asset('storage/'.$user->profile_picture) }}"
                         alt="Your Avatar"
                         class="current-avatar">
                    <button type="button" onclick="removeProfilePicture()" class="delete-btn">
                        Remove Profile Picture
                    </button>
                @endif
                <input id="profile_picture"
                       name="profile_picture"
                       type="file"
                       accept="image/*"
                       class="file-input"
                       onchange="previewImage(event)">
                <img id="preview-avatar" src="#" alt="Preview" class="current-avatar">
                @error('profile_picture')
                <p style="color: red; font-size: 0.875rem;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Save & Delete --}}
            <div class="button-group">
                <button type="submit" class="save-btn">Save Changes</button>
                <button type="button" onclick="openModal()" class="delete-btn">Delete Account</button>
            </div>
        </form>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete your account? This action is irreversible.</p>
            <div class="modal-actions">
                <button class="modal-btn cancel-btn" onclick="closeModal()">Cancel</button>
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modal-btn confirm-btn">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Validate current password via AJAX
        function validateCurrentPassword() {
            const pw = document.getElementById('current_password').value;
            if (!pw) {
                alert('Please enter your current password to continue.');
                return;
            }
            fetch('{{ route('profile.validatePassword') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ current_password: pw })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.valid) {
                        document.getElementById('currentPasswordSection').style.display = 'none';
                        document.getElementById('newPasswordSection').style.display = 'block';
                    } else {
                        alert('Incorrect password. Please try again.');
                    }
                })
                .catch(() => {
                    alert('Error verifying password.');
                });
        }

        // Preview the selected profile picture
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('preview-avatar');
                output.src = reader.result;
                output.style.display = 'block'; // Show the preview
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        // Remove profile picture
        function removeProfilePicture() {
            if (confirm('Are you sure you want to remove your profile picture?')) {
                document.getElementById('profile_picture').value = ''; // Clear the input field
                document.getElementById('preview-avatar').style.display = 'none'; // Hide the preview
            }
        }

        // Modal functions
        function openModal() {
            document.getElementById('deleteModal').style.display = 'flex';
        }
        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }
    </script>
@endsection
