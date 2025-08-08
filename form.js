let image_input = document.getElementById("image-input");
let image_frame = document.getElementById("profile-picture-frame");

let form;
const button = document.getElementById("submit-button");

let dialog;
let bg_dim;

// Update the profile picture when a file has been chosen
image_input?.addEventListener("change", function() {
    const file = image_input.files[0];
    if(file){
        image_frame.src = URL.createObjectURL(file);
    } else {
        image_frame.src = "https://static.vecteezy.com/system/resources/previews/004/511/281/original/default-avatar-photo-placeholder-profile-picture-vector.jpg";
    }
});

// Upon reload, this will load in the image because reloading will remove the image.
if(image_input.files[0])
    image_frame.src = URL.createObjectURL(image_input.files[0]);

/**
* validate Fullname
*/
function validateFullname(fullname_field){
    const require = document.getElementsByClassName("fullname-require-label")[0];
    if(!fullname_field.value){
        require.textContent = "Fullname is required";
        return false;
    }
    require.textContent = "*";
    return true;
}

/**
* validate Date of Birth
*/
function validateDOB(dob_field){
    const require = document.getElementsByClassName("dob-require-label")[0];
    if(!dob_field.value){
        require.textContent = "Date of birth is required";
        return false;
    }

    require.textContent = "*";
    return true;
}

/**
* validate Course
*/
function validateCourse(course_field){
    const require = document.getElementsByClassName("course-require-label")[0];
    if(!course_field.value){
        require.textContent = "Course is required";
        return false;
    }
    require.textContent = "*";
    return true;
}

/**
* validate Email
*/
function validateEmail(email_field){
    const require = document.getElementsByClassName("email-require-label")[0];
    if(!email_field.value){
        require.textContent = "Email is required";
        return false;
    }
    require.textContent = "*";
    return true;
}

/**
* validate Contact
*/
function validateContact(contact_field){
    const require = document.getElementsByClassName("contact-require-label")[0];
    if(!contact_field.value){
        require.textContent = "Contact number is required";
        return false;
    }
    require.textContent = "*";
    return true;
}

/**
* validate input fields
* @returns {boolean}
*/
function validateForm(){
    const fullname_field = document.getElementById("fullname-field");
    const dob_field = document.getElementById("dob-field");
    const course_field = document.getElementById("course-field");
    const contact_field = document.getElementById("contact-field");
    const email_field = document.getElementById("email-field");

    let fullname_valid = validateFullname(fullname_field);
    let dob_valid = validateDOB(dob_field);
    let course_valid = validateCourse(course_field);
    let contact_valid = validateContact(contact_field)
    let email_valid = validateEmail(email_field)

    if(fullname_valid && dob_valid && course_valid && contact_valid && email_valid){
        return true;
    }
    return false;
}

/**
* Reset the form and its inputs to the default states
*/
function resetForm(){
    const fullname_field = document.getElementById("fullname-field");
    const dob_field = document.getElementById("dob-field");
    const course_field = document.getElementById("course-field");
    const contact_field = document.getElementById("contact-field");
    const email_field = document.getElementById("email-field");
    const yearlevel_field = document.getElementById("yearlevel-field");
    const gender_radios = document.getElementsByName("gender-radio");

    form = document.getElementById("registration-form");
    fullname_field.value = "";
    dob_field.value = "";
    course_field.value = "";
    contact_field.value = "";
    email_field.value = "";
    fullname_field.value = "";
    yearlevel_field.value = 1;
    gender_radios[0].checked = true;
    image_frame.src = "https://static.vecteezy.com/system/resources/previews/004/511/281/original/default-avatar-photo-placeholder-profile-picture-vector.jpg";
    hideDialog();
}

/** 
* builds and shows the confirmation dialog
* @param {PointerEvent} event 
* @param {string} message 
*/
function showDialog(event, message) {
    event.preventDefault();
    bg_dim = document.createElement("div")
    bg_dim.setAttribute("class", "bg-dim")

    dialog = document.createElement("div")
    dialog.setAttribute("class", "confirm-dialog-container")

    let panel = document.createElement("div")
    panel.setAttribute("class", "confirm-dialog")

    let header_panel = document.createElement("div")
    header_panel.setAttribute("class", "dialog-header")

    let header = document.createElement("p")
    header.setAttribute("class", "dialog-header-label")
    header.innerHTML = "Confirm";

    let body = document.createElement("div")
    body.setAttribute("class", "dialog-body");

    let body_label = document.createElement("p")
    body_label.setAttribute("class", "body-label");
    body_label.innerHTML = message;

    let button_panel = document.createElement("div")
    button_panel.setAttribute("class", "dialog-button-row");

    let cancel_button = document.createElement("button")
    cancel_button.setAttribute("class", "dialog-button")
    cancel_button.setAttribute("type", "button")
    cancel_button.setAttribute("name", "dialog-cancel-button")
    cancel_button.innerHTML = "Cancel";
    cancel_button.onclick = function () {hideDialog()}

    let submit_button = document.createElement("button")
    submit_button.setAttribute("class", "dialog-button bold")
    submit_button.setAttribute("type", "button")
    submit_button.setAttribute("name", "dialog-submit-button")
    submit_button.onclick = function () {resetForm()};
    submit_button.innerHTML = "OK";

    header_panel.appendChild(header)

    body.appendChild(body_label)

    button_panel.appendChild(submit_button)
    button_panel.appendChild(cancel_button)

    panel.appendChild(header_panel)
    panel.appendChild(body)
    panel.appendChild(button_panel)

    dialog.appendChild(panel)

    document.body.appendChild(dialog)
    document.body.appendChild(bg_dim)
}

// Hide the confirmation dialog
function hideDialog(){
    dialog.remove();
    bg_dim.remove();
}
