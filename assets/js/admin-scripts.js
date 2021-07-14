window.addEventListener('DOMContentLoaded', function (event) {

    // admin page fields script
    let inputToggles = document.querySelectorAll('.ccd_switch');
    if (inputToggles.length > 0) {

        inputToggles.forEach(function (toggle) {

            toggle.addEventListener('click', function () {
                let toggleCheckBox = toggle.querySelector('input[type="checkbox"]');

                if (toggleCheckBox.checked) {
                    toggleCheckBox.value = 'checked'
                } else {
                    toggleCheckBox.value = 'unchecked'
                }

            }, false);

        });
    }


    // client profile page fields uploader logic
    let uploaderButtons = document.querySelectorAll('a.ccd_upload_client_content');
    if (uploaderButtons.length > 0) {

        uploaderButtons.forEach(function (button) {
            button.addEventListener('click', function (event) {
                'use strict';
                let file_frame;

                event.preventDefault();

                // get upload type
                let userId = button.dataset.userId;
                let fieldId = button.dataset.fieldId;
                let contentType = button.dataset.contentType;

                // setup uploader attr
                let uploaderTitle;
                let uploaderButtonTxt;
                let uploaderFileType;

                if (contentType == 'png') {

                    uploaderTitle = 'Add PNG File';
                    uploaderButtonTxt = 'Add Selected PNG Files';
                    uploaderFileType = 'image/png';

                } else if (contentType == 'eps') {

                    uploaderTitle = 'Add EPS (Vector) File';
                    uploaderButtonTxt = 'Add Selected EPS (Vector) File';
                    uploaderFileType = ['image/svg', 'image/svg+xml', 'image/vnd.adobe.illustrator', 'application/postscript', 'image/x-eps'];

                } else if (contentType == 'font') {

                    uploaderTitle = 'Add Font File';
                    uploaderButtonTxt = 'Add Selected Font Files';
                    uploaderFileType = ['application/x-font-ttf', 'application/x-font-truetype', 'application/x-font-opentype', 'font/opentype', 'application/font-woff', 'application/font-woff2', 'application/vnd.ms-fontobject', 'application/font-sfnt'];

                } else {

                    uploaderTitle = 'Add File';
                    uploaderButtonTxt = 'Add Selected File';
                    uploaderFileType = 'image';
                }

                let uploaderOptions = {
                    title: uploaderTitle,
                    library: {
                        type: uploaderFileType,
                    },
                    multiple: true,
                    button: {
                        text: uploaderButtonTxt
                    },
                }

                if (typeof file_frame != 'undefined') {
                    file_frame.close();
                    return;
                }

                // setup fileframe
                file_frame = wp.media.frames.file_frame = wp.media(uploaderOptions);

                // handle open event
                file_frame.on('open', function () {

                    let selection = file_frame.state().get('selection');
                    let fileInput = document.querySelector(`#${fieldId} > input.ccd_selected_files`);

                    if (fileInput !== null) {

                        if (fileInput.value.length > 0) {
                            let ids = fileInput.value.split(',');

                            ids.forEach(function (id) {
                                let attachment = wp.media.attachment(id);
                                attachment.fetch();
                                selection.add(attachment ? [attachment] : []);
                            });

                        }

                    }

                });

                // handle select event
                file_frame.on('select', function () {

                    let attachment = file_frame.state().get('selection').toJSON();
                    let fileInput = document.querySelector(`#${fieldId} > input.ccd_selected_files`);
                    let selectedFiles = [];
                    let selectedFilesObj = [];
                    let preSelectedItesm = fileInput.value.split(',');

                    if (fileInput !== null) {

                        attachment.forEach(function (item) {

                            if (preSelectedItesm.length > 0) {

                                if (preSelectedItesm.includes(item.id) == false) {
                                    selectedFiles.push(item.id);
                                    selectedFilesObj.push(item);
                                }

                            } else {
                                selectedFiles.push(item.id);
                                selectedFilesObj.push(item);
                            }

                        });

                        fileInput.value = selectedFiles;
                    }

                    let selectedFilesDisplay = document.querySelector(`#${fieldId} > .cdd_client_selected_files`);
                    if (selectedFilesDisplay !== null && selectedFilesObj.length > 0) {

                        let html = '';

                        selectedFilesObj.forEach(function (selectedItem) {
                            let imageIcon = selectedItem.type == 'image' ? selectedItem.url : selectedItem.icon;
                            html += `<a href="${selectedItem.url}" class="cdd_client_file">`;
                            html += `<button class="cdd_client_file_remove" data-attachment-id="${selectedItem.id}">X</button>`;
                            html += `<img class="cdd_client_file_icon" src="${imageIcon}">`;
                            html += `<p class="cdd_client_label">${selectedItem.title}</p>`;
                            html += `<a>`;
                        });

                        if (selectedFilesDisplay.querySelectorAll('.cdd_client_file').length > 0) {
                            selectedFilesDisplay.innerHTML += html;
                        } else {
                            selectedFilesDisplay.innerHTML = html;
                        }

                    }

                });

                file_frame.open();

            }, false);
        });

    }

}); // document ready