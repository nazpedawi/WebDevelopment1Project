<div class="container-fluid d-flex justify-content-center align-items-center my-5">
    <div class="row w-100">
        <div class="col-12 col-md-6 offset-md-3">
            <div class="card bg-dark text-white h-100 border border-light rounded">
                <div class="card-header">
                    <h4 class="text-center">Login</h4>
                </div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <!-- Display error if there is a login issue -->
                    <?php if (isset($_SESSION['login_error'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $_SESSION['login_error']; ?>
                        </div>
                        <?php unset($_SESSION['login_error']); ?>
                    <?php endif; ?>

                
                    <form action="/login" method="POST" class="flex-grow-1">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-4 text-center">
                            <button type="submit" class="btn btn-outline-light btn-lg w-100">Login</button>
                        </div>
                    </form>

                    <p class="text-center mt-2">Don't have an account? 
                        <a href="/signup">Sign up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
