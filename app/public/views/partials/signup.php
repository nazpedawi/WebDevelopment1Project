<div class="container-fluid d-flex justify-content-center align-items-center">
    <div class="row w-100">
        <div class="col-12 col-md-6 offset-md-3">
            <div class="card bg-dark text-white h-100 border border-light rounded">
                <div class="card-header">
                    <h4 class="text-center">Sign Up</h4>
                </div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <form action="/signup" method="POST" class="signup-form">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" required>
                            </div>

                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <!-- Hidden input for role, defaulting to "RegularUser" -->
                        <input type="hidden" name="role" value="RegularUser">

                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-outline-light btn-lg w-100">Sign Up</button>
                        </div>
                    </form>
                    <p class="text-center mt-3">Already have an account? 
                        <a href="/login">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
