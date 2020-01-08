$(document).ready(function() {

    // image preview
    $(".image").change(function() {

        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = (e) => {
                $(this).parent('.form-group').next('.image-preview').find('img').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        }

    });

}); //end of document ready