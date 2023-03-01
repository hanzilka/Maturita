let file = document.getElementById("file");
if(file !== null && file !== undefined){
   file.onchange = function() {
   document.getElementById("file-label").innerHTML = this.files[0].name;
   document.getElementById("id").value = "<?php echo $id; ?>";
   }
}
//
const edit_cover = document.getElementById("edit_cover");
const obal = document.getElementById("obal");

edit_cover.addEventListener("change", toggleCoverImageInput);

function toggleCoverImageInput() {
  if (edit_cover.checked) {
    obal.style.display = "block";
    obal.disabled = false;
  } else {
    obal.style.display = "none";
    obal.disabled = true;
  }
}