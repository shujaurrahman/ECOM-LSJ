<?php 
session_start();
require_once('header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['name']) && !empty($_POST['subject']) && !empty($_POST['message']) && !empty($_POST['rating'])) {
        require_once('./logics.class.php');
        $Obj = new logics();

        // Handle file upload
        $image = '';
        if(isset($_FILES['user_image']) && $_FILES['user_image']['error'] == 0) {
            $image = time() . '_' . $_FILES['user_image']['name'];
            move_uploaded_file($_FILES['user_image']['tmp_name'], './testimonial/' . $image);
        }

        $verification = $Obj->AddTestimonial($_POST['name'], $_POST['subject'], $_POST['message'], $_POST['rating'], $image);
        if (!empty($verification['status']) && $verification['status'] == 1) {
            echo '<script src="./panels/js/sweetalert.js"></script>';
            echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Testimonial submitted successfully!",
                    showConfirmButton: true,
                }).then(function() {
                    window.location.href = "testimonial.php";
                });
            </script>';
        } else {
            echo '<script src="./panels/js/sweetalert.js"></script>';
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Submission failed!",
                    text: "Please try again"
                }).then(function() {
                    window.location.href = "testimonial.php";
                });
            </script>';
        }
    }
}
?>

<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <span class="breadcrumb-item active">testimonial</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Testimonial Form Start -->
<div class="container-fluid">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">Share Your Experience</span>
    </h2>
    <div class=" px-xl-5">
        <div class="col-lg-12 mb-5">
            <div class="contact-form bg-light p-30">
                <form action="./testimonial.php" method="post" enctype="multipart/form-data">
                    <div class="control-group mb-3">
                        <input type="text" class="form-control" name="name" placeholder="Your Name" required />
                    </div>
                    <div class="control-group mb-3">
                        <input type="text" class="form-control" name="subject" placeholder="Subject" required />
                    </div>
                    <div class="control-group mb-3">
                        <input type="file" class="form-control" name="user_image" accept="image/*" />
                        <small class="text-muted">Upload your photo (optional)</small>
                    </div>
                    <div class="control-group mb-3">
                        <textarea class="form-control" rows="8" name="message" placeholder="Your Message" required></textarea>
                    </div>
                    <div class="control-group mb-3">
                        <label>Your Rating *</label>
                        <div class="text-primary d-flex" id="product-rating">
                            <i class="far fa-star" data-rating="1"></i>
                            <i class="far fa-star" data-rating="2"></i>
                            <i class="far fa-star" data-rating="3"></i>
                            <i class="far fa-star" data-rating="4"></i>
                            <i class="far fa-star" data-rating="5"></i>
                        </div>
                        <input type="hidden" name="rating" id="selected-rating" value="0">
                    </div>
                    <div>
                        <button class="btn btn-primary py-2 px-4" type="submit">Submit Testimonial</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Testimonial Form End -->

<style>
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    gap: 4px;
    margin: 10px 0;
}

.star-rating input {
    display: none;
}

.star-rating label {
    cursor: pointer;
    width: 30px;
    height: 30px;
    background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>');
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
    filter: grayscale(100%);
}

.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    filter: grayscale(0%);
    filter: brightness(100%) saturate(100%) hue-rotate(0deg);
}

#product-rating {
    gap: 5px;
    padding: 10px 0;
}

#product-rating i {
    cursor: pointer;
    font-size: 20px;
    color: #FFD333;
}

#product-rating i.far {
    color: #ddd;
}

#product-rating i:hover,
#product-rating i:hover ~ i {
    color: #FFD333;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('#product-rating i');
    const ratingInput = document.getElementById('selected-rating');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            ratingInput.value = rating;

            // Reset all stars
            stars.forEach(s => {
                s.classList.remove('fas');
                s.classList.add('far');
            });

            // Fill stars up to selected rating
            stars.forEach(s => {
                if (s.getAttribute('data-rating') <= rating) {
                    s.classList.remove('far');
                    s.classList.add('fas');
                }
            });
        });

        // Hover effect
        star.addEventListener('mouseover', function() {
            const rating = this.getAttribute('data-rating');
            
            stars.forEach(s => {
                if (s.getAttribute('data-rating') <= rating) {
                    s.classList.remove('far');
                    s.classList.add('fas');
                }
            });
        });

        star.addEventListener('mouseout', function() {
            const currentRating = ratingInput.value;
            
            stars.forEach(s => {
                s.classList.remove('fas');
                s.classList.add('far');
                
                if (currentRating && s.getAttribute('data-rating') <= currentRating) {
                    s.classList.remove('far');
                    s.classList.add('fas');
                }
            });
        });
    });
});
</script>

<?php
require_once('footer.php');
?>