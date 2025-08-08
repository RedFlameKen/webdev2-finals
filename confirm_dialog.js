// @ts-check

/** @type HTMLElement */
let dialog;

/** @type HTMLElement */
let bg_dim;

/** 
* Builds and shows a confirmation dialog. This one is specifically made for php
* redirects.
*
* @param {string} message 
* @param {number} id 
* @param {string} destination 
*/
function showDialog(message, id, destination) {
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

    let form = document.createElement("form")
    form.setAttribute("method", "post")
    form.setAttribute("action", destination)

    let submit_button = document.createElement("button")
    submit_button.setAttribute("class", "dialog-button bold")
    submit_button.setAttribute("type", "submit")
    submit_button.setAttribute("name", "dialog-submit-button")
    submit_button.setAttribute("value", "" + id)
    submit_button.innerHTML = "OK";

    header_panel.appendChild(header)

    body.appendChild(body_label)

    form.appendChild(submit_button)
    button_panel.appendChild(form)
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
