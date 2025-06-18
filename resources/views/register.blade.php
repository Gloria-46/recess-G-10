<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UpTrend | Signup</title>
    @vite (['resources/css/admin/register.css','resources/js/admin/register.js'])
</head>
<body>
    <div class="container">
      <header>Signup Form</header>
      <div class="progress-bar">
        <div class="step">
          <p>Name</p>
          <div class="bullet">
            <span>1</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
        <div class="step">
          <p>Contact</p>
          <div class="bullet">
            <span>2</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
        <div class="step">
          <p>Address</p>
          <div class="bullet">
            <span>3</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
        <div class="step">
          <p>Submit</p>
          <div class="bullet">
            <span>4</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
      </div>
      <div class="form-outer">
        <form method="POST" action="{{ route('register') }}">
          @csrf
          <div class="page slide-page">
            <div class="title">Personal Information:</div>
            <div class="field">
              <div class="label">First Name</div>
              <input type="text">
            </div>
            <div class="field">
              <div class="label">Last Name</div>
              <input type="text">
            </div>
            <div class="field">
              <div class="label">Date of Birth</div>
              <input type="text">
            </div>
            <div class="field">
              <div class="label">Age</div>
              <input type="number">
            </div>
            <div class="field">
                <div class="label">Gender</div>
                <select>
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                </select>
            </div>
            <div class="field">
              <button class="firstNext next">Next</button>
            </div>
          </div>

          <div class="page">
            <div class="title">Contact Information:</div>
            <div class="field">
              <div class="label">Email Address</div>
              <input type="text">
            </div>
            <div class="field">
              <div class="label">Phone Number</div>
              <input type="tel">
            </div>
            <div class="field btns">
              <button class="prev-1 prev">Previous</button>
              <button class="next-1 next">Next</button>
            </div>
        </div>

        <div class="page">
            <div class="title">Address Information:</div>
            <div class="field">
                <div class="label">Country</div>
                <input type="text">
            </div>
            <div class="field">
                <div class="label">City</div>
                <input type="text">
            </div>
            <div class="field">
                <div class="label">Location</div>
                <input type="text">
            </div>
            <div class="field">
                <div class="label">Postal Address</div>
                <input type="text">
            </div>
            <div class="field btns">
              <button class="prev-2 prev">Previous</button>
              <button class="next-2 next">Next</button>
            </div>
          </div>

          <div class="page">
            <div class="title">Login Details:</div>
            <div class="field">
              <div class="label">Username</div>
              <input type="text">
            </div>
            <div class="field">
              <div class="label">Password</div>
              <input type="password">
            </div>
            <div class="field btns">
              <button class="prev-3 prev">Previous</button>
              <a href="/"><button class="submit">Submit</button></a>
            </div>
            <div class="register">
                <p>Already have an account? <a href="/">Sign in</a></p>
            </div>
          </div>
        </form>
      </div>
        @foreach ($errors->all() as $error)
            <div class="alert alert-warning alert-dismissible fade show" >
                <a href="#" class="close" data-dismiss="alert" aria-label="close"> &times;</a>
                {{ $error }}
            </div>
        @endforeach
    </div>
</body>
@push('js')
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();

            setTimeout(function() {
                // after 1000 ms we add the class animated to the login/register card
                $('.card').removeClass('card-hidden');
            }, 700)
        });
    </script>
@endpush
</html>