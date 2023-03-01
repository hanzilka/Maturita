document.addEventListener("DOMContentLoaded", function(){
    var elements = document.querySelectorAll('[data-toggle="tooltip"]');
    for(var i = 0; i < elements.length; i++){
        elements[i].addEventListener('mouseover', function(){
            var originalTitle = this.getAttribute('data-original-title');
            if (originalTitle) {
                this.setAttribute('title', originalTitle);
                this.setAttribute('data-original-title', '');
            }
        });
        elements[i].addEventListener('mouseout', function(){
            var currentTitle = this.getAttribute('title');
            if (currentTitle) {
                this.setAttribute('data-original-title', currentTitle);
                this.setAttribute('title', '');
            }
        });
    }
});
