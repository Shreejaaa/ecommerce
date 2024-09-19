function previewImages() {
    var preview = document.getElementById('imagePreview');
    preview.innerHTML = ''; // Clear existing images
    Array.from(this.files).forEach(file => {
        if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
            return alert(file.name + " is not an image");
        } else {
            var reader = new FileReader();
            reader.onload = function(event) {
                var img = new Image();
                img.src = event.target.result;
                img.style.height = '100px';
                img.style.margin = '5px';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
}

document.getElementById('shopImage').addEventListener('change', previewImages);
