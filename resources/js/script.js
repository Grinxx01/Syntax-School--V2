document.addEventListener("DOMContentLoaded", function () {
    const dropdownBtn = document.querySelector(".dropdown-btn");
    const profile = document.querySelector(".profile");

    if (dropdownBtn && profile) {
        dropdownBtn.addEventListener("click", function (event) {
            console.log("Dropdown button clicked");
            event.stopPropagation(); // Prevent propagation to document listener
            profile.classList.toggle("show");
        });

        document.addEventListener("click", function (e) {
            if (!profile.contains(e.target)) {
                console.log("Click outside dropdown");
                profile.classList.remove("show");
            }
        });
    } else {
        console.error("Dropdown button or profile element not found.");
    }
});

function addInput() {
    var dynamicInputsDiv = document.getElementById("input_sections") || document.getElementById("dynamic-inputs");

    if (!dynamicInputsDiv) {
        console.error("Element with ID 'input_sections' or 'dynamic-inputs' not found.");
        return;
    }

    var newInputGroup = document.createElement("div");
    newInputGroup.className = "input_section";
    
    newInputGroup.innerHTML = `
        <label for="tipe_input">Tipe Input:</label>
        <select name="tipe_input[]" onchange="handleInputChange(this)" required>
            <option value="">Pilih Tipe Input</option>
            <option value="text">Text</option>
            <option value="code">Code</option>
            <option value="file">File</option>
        </select>

        <div class="additional_input"></div>
        <button type="button" onclick="removeInput(this)">Hapus</button>
    `;
    
    dynamicInputsDiv.appendChild(newInputGroup);
}

function removeInput(button) {
    button.parentElement.remove();
}

function handleInputChange(selectElement) {
    var selectedValue = selectElement.value;
    var inputSection = selectElement.closest('.input_section');
    var additionalInputDiv = inputSection.querySelector('.additional_input');

    additionalInputDiv.innerHTML = '';

    if (selectedValue === 'text') {
        additionalInputDiv.innerHTML = `
            <label>Isi Materi:</label>
            <textarea name="isi_materi[]" required></textarea>
        `;
    } else if (selectedValue === 'code') {
        additionalInputDiv.innerHTML = `
            <label>Contoh Code:</label>
            <textarea name="contoh_code[]"></textarea>
        `;
    } else if (selectedValue === 'file') {
        additionalInputDiv.innerHTML = `
            <label>File Materi:</label>
            <input type="file" name="file_materi[]" accept=".pdf,.doc,.docx,.ppt,.pptx">
        `;
    }
}

(function() {
    let questionCounter = 1;

    window.addQuestion = function() {
        const questionList = document.getElementById('question-list');
        questionCounter++;

        const questionWrapper = document.createElement('div');
        questionWrapper.className = 'question-wrapper';
        questionWrapper.id = `question-${questionCounter}`;

        questionWrapper.innerHTML = `
            <label for="question-${questionCounter}">Pertanyaan ${questionCounter}:</label>
            <input type="text" name="questions[]" id="question-${questionCounter}" required>
            <div class="options">
                <label for="option-a-${questionCounter}">Opsi A:</label>
                <input type="text" name="options[${questionCounter}][]" id="option-a-${questionCounter}" required>
                <label for="option-b-${questionCounter}">Opsi B:</label>
                <input type="text" name="options[${questionCounter}][]" id="option-b-${questionCounter}" required>
                <label for="option-c-${questionCounter}">Opsi C:</label>
                <input type="text" name="options[${questionCounter}][]" id="option-c-${questionCounter}" required>
                <label for="option-d-${questionCounter}">Opsi D:</label>
                <input type="text" name="options[${questionCounter}][]" id="option-d-${questionCounter}" required>
            </div>
            <label for="answer-${questionCounter}">Jawaban Benar:</label>
            <select name="answers[]" id="answer-${questionCounter}" required>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
            <button type="button" onclick="removeQuestion(${questionCounter})">Hapus Pertanyaan</button>
        `;

        questionList.appendChild(questionWrapper);
    };

    window.removeQuestion = function(id) {
        const question = document.getElementById(`question-${id}`);
        if (question) {
            question.remove();
        }
    };
})();
