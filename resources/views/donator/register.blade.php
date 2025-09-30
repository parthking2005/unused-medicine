@extends('donator.layouts.app')
@section('content')

    <!-- breadcrumb start-->
    <section class="breadcrumb breadcrumb_bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb_iner">
                        <div class="breadcrumb_iner_item text-center">
                            <h2>Register</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end-->
    <div class="container pt-5 pb-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6">
                @include('partial.customerror')
                @include('partial.success')
                <form method="POST" action="{{ route('RegisterDonator') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label><strong>Name</strong></label>
                        <input type="text" name="name" 
                                class="form-control @error('name') is-invalid @enderror" 
                                onfocus="this.placeholder = ''" 
                                onblur="this.placeholder = 'Enter name'" 
                                value="{{ old('name') }}"
                                placeholder='Enter name' required>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label><strong>Email</strong></label>
                        <input type="email" name="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                onfocus="this.placeholder = ''" 
                                onblur="this.placeholder = 'Enter email'"  
                                value="{{ old('email') }}"
                                placeholder='Enter email' required>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label><strong>Password</strong></label>
                        <input type="password" name="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                onfocus="this.placeholder = ''" 
                                onblur="this.placeholder = 'Enter password'"  
                                value="{{ old('password') }}"
                                placeholder='Enter password' required>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label><strong>Gender</strong></label><br>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input @error('gender') is-invalid @enderror" id="male" 
                                    name="gender" value="Male" @if(old('gender')=='Male') checked @endif >
                            <label class="custom-control-label" for="male">Male</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input @error('gender') is-invalid @enderror" id="female" 
                                    name="gender" value="Female" @if(old('gender')=='Female') checked @endif >
                            <label class="custom-control-label" for="female">Female</label>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label><strong>Contact</strong></label>
                        <input type="text" name="contact" 
                                class="form-control @error('contact') is-invalid @enderror" 
                                onfocus="this.placeholder = ''" 
                                onblur="this.placeholder = 'Enter contact'"  
                                value="{{ old('contact') }}"
                                placeholder='Enter contact' required
                                maxlength="10"
                                pattern="\d{10}">
                        @error('contact')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label><strong>Address</strong></label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                onfocus="this.placeholder = ''" 
                                onblur="this.placeholder = 'Enter Address'" 
                                placeholder='Enter Address' rows="2" name="address">{{ old('address') }}</textarea>
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label><strong>Pincode</strong></label>
                        <input type="text" name="pincode" id="pincode" 
                                class="form-control @error('pincode') is-invalid @enderror" 
                                onfocus="this.placeholder = ''" 
                                onblur="this.placeholder = 'Enter pincode'"   
                                value="{{ old('pincode') }}"
                                placeholder='Enter pincode' required
                                maxlength="6"
                                pattern="\d{6}">
                        <span role="alert"><strong id="errpncd" style="Color:red"></strong></span>
                        @error('pincode')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label><strong>City</strong></label>
                        <input type="text" name="city" id="city" 
                                class="form-control @error('city') is-invalid @enderror" 
                                onfocus="this.placeholder = ''" 
                                onblur="this.placeholder = 'Enter city'"   
                                value="{{ old('city') }}"
                                placeholder='Enter city' required>
                        @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label><strong>State</strong></label>
                        <input type="text" name="state" id="state" 
                                class="form-control @error('state') is-invalid @enderror" 
                                onfocus="this.placeholder = ''" 
                                onblur="this.placeholder = 'Enter state'"   
                                value="{{ old('state') }}"
                                placeholder='Enter state' required>
                        @error('state')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label><strong>Profile Image</strong></label>
                        <div class="media pb-2">
                            <img src="https://mdbootstrap.com/img/Photos/Others/placeholder-avatar.jpg" id="viewimage" class="mr-3" alt="example placeholder avatar" height="100" width="100">
                        </div>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="pimage" accept="image/*" onchange="LoadPhoto(event)">
                                <label class="custom-file-label">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn_3 ">Register</button>
                    </div>
                </form>
                <div class="new-account mt-3">
                    <p>Already have an account? <a class="text-primary" href="{{ route('LoginDonator') }}">Login</a></p>
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function() {
        $('form').on('input', function() {
            var isValid = true;
            $('input[required]').each(function() {
                if ($(this).val() === '' || $(this).val().length > $(this).attr('maxlength') || !$(this).val().match(new RegExp($(this).attr('pattern')))) {
                    isValid = false;
                }
            });
            $('button[type="submit"]').prop('disabled', !isValid);
        });
    });

    function LoadPhoto(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('viewimage');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection