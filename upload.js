const dropArea = document.getElementById('drop-area');
const form = document.getElementById('artUploadForm');

// Drag and drop handlers
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, preventDefaults, false);
    document.body.addEventListener(eventName, preventDefaults, false);
});

['dragenter', 'dragover'].forEach(eventName => {
    dropArea.addEventListener(eventName, highlightArea, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, unhighlightArea, false);
});

dropArea.addEventListener('drop', handleDrop, false);
dropArea.addEventListener('click', () => document.getElementById('imageInput').click());

// Handle file selection
document.getElementById('imageInput').addEventListener('change', function () {
  handleFiles(this.files);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

function highlightArea() {
    dropArea.classList.add('dragover');
}

function unhighlightArea() {
    dropArea.classList.remove('dragover');
}

function handleDrop(e) {
  const dt = e.dataTransfer;
  const files = dt.files;

  if (files && files.length > 0) {
      handleFiles(files);
  }
}


function handleFiles(files) {
  const file = files instanceof FileList ? files[0] : files;
  if (file && file instanceof Blob) {
      previewFile(file);
  } else {
      console.error("Invalid file selected", file);
  }
}


function previewFile(file) {
    const reader = new FileReader();
    reader.onload = (e) => {
        const previewBox = document.getElementById('previewBox');
        previewBox.innerHTML = `
            <img src="${e.target.result}" class="preview-image" />
            <div class="file-info">
                ${file.name} (${(file.size/1024/1024).toFixed(2)}MB)
            </div>
        `;
    };
    reader.readAsDataURL(file);
}

// Form submission
form.addEventListener("submit", async (e) => {
  e.preventDefault();

  const formData = new FormData(form);

  // Upload image to server
  const imageOnlyFormData = new FormData();
  const imageInput = document.getElementById("imageInput");
  imageOnlyFormData.append("art", imageInput.files[0]);
  
  const imageUploadRes = await fetch("upload.php", {
      method: "POST",
      body: imageOnlyFormData
  });

  const uploadResult = await imageUploadRes.json();

  if (uploadResult.status === 1) {
      // Send all form data to save_art.php
      const artData = {
          title: formData.get("title"),
          description: formData.get("description"),
          category: formData.get("category"),
          price: formData.get("price"),
          username: "vikash", // Replace with actual user if dynamic
          imagePath: uploadResult.path
      };

      const saveRes = await fetch("save_art.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(artData)
      });

      const saveResult = await saveRes.json();
      alert(saveResult.message);

      form.reset();
      document.getElementById("previewBox").innerHTML = '';
  } else {
      alert("Image upload failed: " + uploadResult.message);
  }
});
