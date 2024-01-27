const CLIENT_ID = '75132863473-h6i0tqj5tuc7jbm6ptjgrlb7snvv8im6.apps.googleusercontent.com';
const CLIENT_SECRET = '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';

// Discovery URL for APIs used by the quickstart
const DISCOVERY_DOC = 'https://www.googleapis.com/discovery/v1/apis/drive/v3/rest';

const KEYFILEPATH = 'C:\\xampp\\htdocs\\cvsu_accrsystem\\cvsu-accreditation-37a00b400711.json';

const SCOPES = 'https://www.googleapis.com/auth/drive.file';
let tokenClient;
let gapiInited = false;
let gisInited = false;

//Callback after api.js is loaded.
function gapiLoaded() {
	gapi.load('client', initializeGapiClient);
}

//Callback after the API client is loaded. Loads the discovery doc to initialize the API.
async function initializeGapiClient() {
	await gapi.client.init({
		client_secret: CLIENT_SECRET,
		discoveryDocs: [DISCOVERY_DOC],
	});
	gapiInited = true;
	maybeEnableButtons();
}

//Callback after Google Identity Services are loaded.
function gisLoaded() {
	tokenClient = google.accounts.oauth2.initTokenClient({
		client_id: CLIENT_ID,
		scope: SCOPES, 
		callback: '',
	});
	gisInited = true;
	maybeEnableButtons();
}

//Enables user interaction after all libraries are loaded.
function maybeEnableButtons() {
	if (gapiInited && gisInited) {
	}
}

//Sign in the user upon button click.
function handleAuthClick() {
	tokenClient.callback = async (resp) => {
		if (resp.error !== undefined) {
			throw (resp);
		}
		document.getElementById('signout_button').style.visibility = 'visible';
        document.getElementById('authorize_button').style.visibility = 'hidden';
        document.getElementById('fileInput').style.visibility = 'visible';
		document.getElementById('uploadButton').style.visibility = 'visible';
	};
	if (gapi.client.getToken() === null) {
		tokenClient.requestAccessToken({ prompt: '' });
	} else {
		tokenClient.requestAccessToken({ prompt: '' });
	}
}

//Sign out the user upon button click.
function handleSignoutClick() {
	const token = gapi.client.getToken();
	if (token !== null) {
		google.accounts.oauth2.revoke(token.access_token);
		gapi.client.setToken('');
		document.getElementById('content').style.display = 'none';
		document.getElementById('content').innerHTML = '';
		document.getElementById('authorize_button').value = 'Authorize';
		document.getElementById('signout_button').style.visibility = 'hidden';
        document.getElementById('fileInput').style.visibility = 'hidden';
        document.getElementById('uploadButton').style.visibility = 'hidden';
	}
}

function uploadFile() {      
    const fileInput = document.getElementById('fileInput');
    const selectedFile = fileInput.files[0];
	const directory = document.getElementById('directories').value;
    if (!selectedFile) {
        alert('Please select a file to upload.');
        return;
    }
    // Check if the selected file type is allowed
    const allowedTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/png', 'image/jpeg', 'image/jpg'];
    if (!allowedTypes.includes(selectedFile.type)) {
        alert('Only PDF, DOCX, PNG, JPG, and JPEG files are allowed.');
        return;
    }

    var file = new Blob([selectedFile], {type: selectedFile.type});

	switch (directory) {
		case "CAFENR":
			var fileName = selectedFile.name;
			var parent = '1TOtgbbPoKIr3JZNyVfP4D6SJdYf3aOW_';
			gapi.client.drive.files.list({
				q: `name='${fileName}' and '${parent}' in parents`,
				spaces: 'drive',
			}).then((response) => {
				const files = response.result.files;
        		if (files && files.length > 0) {
					alert("File: " + selectedFile.name + " already exists in the database.");
				} else {
					var metadata = {
						'name': fileName,
						'mimeType': selectedFile.type,
						'parents': ['1TOtgbbPoKIr3JZNyVfP4D6SJdYf3aOW_']
					};
					var formData = new FormData();
					formData.append("metadata", new Blob([JSON.stringify(metadata)], { type: 'application/json' }));
					// set file as blob formate
					formData.append("file", selectedFile);
					fetch("https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&fields=id,name,webViewLink,webContentLink", {
						method: 'POST',
						headers: new Headers({ "Authorization": "Bearer " + gapi.auth.getToken().access_token }),
						body: formData
					}).then(function (response) {
						return response.json();
					}).then(function (value) {
						console.log(value);
						// file is uploaded and values set as cookies
						localStorage.setItem('file_id', value.id);
						localStorage.setItem('file_name', value.name);
						localStorage.setItem('file_viewLink', value.webViewLink);
						localStorage.setItem('file_downloadLink', value.webContentLink);
						document.cookie = "file_id=" + value.id;
						document.cookie = "file_name=" + value.name;
						document.cookie = "view_link=" + value.webViewLink;
						document.cookie = "download_link=" + value.webContentLink;
					});
				}
			}).catch((error) => {
				console.error('Error checking file existence:', error);
			});
			break;
		case "CAS":
			var fileName = selectedFile.name;
			var parent = '1_iD1SgmR0j842o0Oo0W2BOohmSf5tbGR';
			gapi.client.drive.files.list({
				q: `name='${fileName}' and '${parent}' in parents`,
				spaces: 'drive',
			}).then((response) => {
				const files = response.result.files;
        		if (files && files.length > 0) {
					alert("File: " + selectedFile.name + " already exists in the database.");
				} else {
					var metadata = {
						'name': fileName,
						'mimeType': selectedFile.type,
						'parents': ['1_iD1SgmR0j842o0Oo0W2BOohmSf5tbGR']
					};
					var formData = new FormData();
					formData.append("metadata", new Blob([JSON.stringify(metadata)], { type: 'application/json' }));
					formData.append("file", selectedFile);
					fetch("https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&fields=id,name,webViewLink,webContentLink", {
						method: 'POST',
						headers: new Headers({ "Authorization": "Bearer " + gapi.auth.getToken().access_token }),
						body: formData
					}).then(function (response) {
						return response.json();
					}).then(function (value) {
						console.log(value);
						localStorage.setItem('file_id', value.id);
						localStorage.setItem('file_name', value.name);
						localStorage.setItem('file_viewLink', value.webViewLink);
						localStorage.setItem('file_downloadLink', value.webContentLink);
						document.cookie = "file_id=" + value.id;
						document.cookie = "file_name=" + value.name;
						document.cookie = "view_link=" + value.webViewLink;
						document.cookie = "download_link=" + value.webContentLink;
					});
				}
			}).catch((error) => {
				console.error('Error checking file existence:', error);
			});
			break;
		case "CCJ":
			var fileName = selectedFile.name;
			var parent = '1ulh8Z5zVz6iJzO0AXO6GAJQBbP2Dkm7g';
			gapi.client.drive.files.list({
				q: `name='${fileName}' and '${parent}' in parents`,
				spaces: 'drive',
			}).then((response) => {
				const files = response.result.files;
        		if (files && files.length > 0) {
					alert("File: " + selectedFile.name + " already exists in the database.");
				} else {
					var metadata = {
						'name': fileName,
						'mimeType': selectedFile.type,
						'parents': ['1ulh8Z5zVz6iJzO0AXO6GAJQBbP2Dkm7g']
					};
					var formData = new FormData();
					formData.append("metadata", new Blob([JSON.stringify(metadata)], { type: 'application/json' }));
					formData.append("file", selectedFile);
					fetch("https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&fields=id,name,webViewLink,webContentLink", {
						method: 'POST',
						headers: new Headers({ "Authorization": "Bearer " + gapi.auth.getToken().access_token }),
						body: formData
					}).then(function (response) {
						return response.json();
					}).then(function (value) {
						console.log(value);
						localStorage.setItem('file_id', value.id);
						localStorage.setItem('file_name', value.name);
						localStorage.setItem('file_viewLink', value.webViewLink);
						localStorage.setItem('file_downloadLink', value.webContentLink);
						document.cookie = "file_id=" + value.id;
						document.cookie = "file_name=" + value.name;
						document.cookie = "view_link=" + value.webViewLink;
						document.cookie = "download_link=" + value.webContentLink;
					});
				}
			}).catch((error) => {
				console.error('Error checking file existence:', error);
			});
			break;
		case "CED":
			var fileName = selectedFile.name;
			var parent = '1prhnN8SQkVBmg2cO3Nq2RFZXoaYF3bXZ';
			gapi.client.drive.files.list({
				q: `name='${fileName}' and '${parent}' in parents`,
				spaces: 'drive',
			}).then((response) => {
				const files = response.result.files;
        		if (files && files.length > 0) {
					alert("File: " + selectedFile.name + " already exists in the database.");
				} else {
					var metadata = {
						'name': fileName,
						'mimeType': selectedFile.type,
						'parents': ['1prhnN8SQkVBmg2cO3Nq2RFZXoaYF3bXZ']
					};
					var formData = new FormData();
					formData.append("metadata", new Blob([JSON.stringify(metadata)], { type: 'application/json' }));
					formData.append("file", selectedFile);
					fetch("https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&fields=id,name,webViewLink,webContentLink", {
						method: 'POST',
						headers: new Headers({ "Authorization": "Bearer " + gapi.auth.getToken().access_token }),
						body: formData
					}).then(function (response) {
						return response.json();
					}).then(function (value) {
						console.log(value);
						localStorage.setItem('file_id', value.id);
						localStorage.setItem('file_name', value.name);
						localStorage.setItem('file_viewLink', value.webViewLink);
						localStorage.setItem('file_downloadLink', value.webContentLink);
						document.cookie = "file_id=" + value.id;
						document.cookie = "file_name=" + value.name;
						document.cookie = "view_link=" + value.webViewLink;
						document.cookie = "download_link=" + value.webContentLink;
					});
				}
			}).catch((error) => {
				console.error('Error checking file existence:', error);
			});
			break;
		case "CEMDS":
			var fileName = selectedFile.name;
			var parent = '1EGaDpuwOAqrJrP4vW5WhD5iWAMXQra1j';
			gapi.client.drive.files.list({
				q: `name='${fileName}' and '${parent}' in parents`,
				spaces: 'drive',
			}).then((response) => {
				const files = response.result.files;
        		if (files && files.length > 0) {
					alert("File: " + selectedFile.name + " already exists in the database.");
				} else {
					var metadata = {
						'name': fileName,
						'mimeType': selectedFile.type,
						'parents': ['1EGaDpuwOAqrJrP4vW5WhD5iWAMXQra1j']
					};
					var formData = new FormData();
					formData.append("metadata", new Blob([JSON.stringify(metadata)], { type: 'application/json' }));
					formData.append("file", selectedFile);
					fetch("https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&fields=id,name,webViewLink,webContentLink", {
						method: 'POST',
						headers: new Headers({ "Authorization": "Bearer " + gapi.auth.getToken().access_token }),
						body: formData
					}).then(function (response) {
						return response.json();
					}).then(function (value) {
						console.log(value);
						localStorage.setItem('file_id', value.id);
						localStorage.setItem('file_name', value.name);
						localStorage.setItem('file_viewLink', value.webViewLink);
						localStorage.setItem('file_downloadLink', value.webContentLink);
						document.cookie = "file_id=" + value.id;
						document.cookie = "file_name=" + value.name;
						document.cookie = "view_link=" + value.webViewLink;
						document.cookie = "download_link=" + value.webContentLink;
					});
				}
			}).catch((error) => {
				console.error('Error checking file existence:', error);
			});
			break;
		case "CEIT":
			var fileName = selectedFile.name;
			var parent = '1ShUNEQ9F_wN6Nxuyo-8y9j4JKig8dlmg';
			gapi.client.drive.files.list({
				q: `name='${fileName}' and '${parent}' in parents`,
				spaces: 'drive',
			}).then((response) => {
				const files = response.result.files;
        		if (files && files.length > 0) {
					alert("File: " + selectedFile.name + " already exists in the database.");
				} else {
					var metadata = {
						'name': fileName,
						'mimeType': selectedFile.type,
						'parents': ['1ShUNEQ9F_wN6Nxuyo-8y9j4JKig8dlmg']
					};
					var formData = new FormData();
					formData.append("metadata", new Blob([JSON.stringify(metadata)], { type: 'application/json' }));
					formData.append("file", selectedFile);
					fetch("https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&fields=id,name,webViewLink,webContentLink", {
						method: 'POST',
						headers: new Headers({ "Authorization": "Bearer " + gapi.auth.getToken().access_token }),
						body: formData
					}).then(function (response) {
						return response.json();
					}).then(function (value) {
						console.log(value);
						localStorage.setItem('file_id', value.id);
						localStorage.setItem('file_name', value.name);
						localStorage.setItem('file_viewLink', value.webViewLink);
						localStorage.setItem('file_downloadLink', value.webContentLink);
						document.cookie = "file_id=" + value.id;
						document.cookie = "file_name=" + value.name;
						document.cookie = "view_link=" + value.webViewLink;
						document.cookie = "download_link=" + value.webContentLink;
					});
				}
			}).catch((error) => {
				console.error('Error checking file existence:', error);
			});
			break;
		case "CON":
			var fileName = selectedFile.name;
			var parent = '1hqDXkWjvcsB0WKNYw_roijPj9eDTC8fn';
			gapi.client.drive.files.list({
				q: `name='${fileName}' and '${parent}' in parents`,
				spaces: 'drive',
			}).then((response) => {
				const files = response.result.files;
        		if (files && files.length > 0) {
					alert("File: " + selectedFile.name + " already exists in the database.");
				} else {
					var metadata = {
						'name': fileName,
						'mimeType': selectedFile.type,
						'parents': ['1hqDXkWjvcsB0WKNYw_roijPj9eDTC8fn']
					};
					var formData = new FormData();
					formData.append("metadata", new Blob([JSON.stringify(metadata)], { type: 'application/json' }));
					formData.append("file", selectedFile);
					fetch("https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&fields=id,name,webViewLink,webContentLink", {
						method: 'POST',
						headers: new Headers({ "Authorization": "Bearer " + gapi.auth.getToken().access_token }),
						body: formData
					}).then(function (response) {
						return response.json();
					}).then(function (value) {
						console.log(value);
						localStorage.setItem('file_id', value.id);
						localStorage.setItem('file_name', value.name);
						localStorage.setItem('file_viewLink', value.webViewLink);
						localStorage.setItem('file_downloadLink', value.webContentLink);
						document.cookie = "file_id=" + value.id;
						document.cookie = "file_name=" + value.name;
						document.cookie = "view_link=" + value.webViewLink;
						document.cookie = "download_link=" + value.webContentLink;
					});
				}
			}).catch((error) => {
				console.error('Error checking file existence:', error);
			});
			break;
		case "CSPEAR":
			var fileName = selectedFile.name;
			var parent = '1fjGBBGdSEEZmxRIbVl8X-1zFvmIep51o';
			gapi.client.drive.files.list({
				q: `name='${fileName}' and '${parent}' in parents`,
				spaces: 'drive',
			}).then((response) => {
				const files = response.result.files;
        		if (files && files.length > 0) {
					alert("File: " + selectedFile.name + " already exists in the database.");
				} else {
					var metadata = {
						'name': fileName,
						'mimeType': selectedFile.type,
						'parents': ['1fjGBBGdSEEZmxRIbVl8X-1zFvmIep51o']
					};
					var formData = new FormData();
					formData.append("metadata", new Blob([JSON.stringify(metadata)], { type: 'application/json' }));
					formData.append("file", selectedFile);
					fetch("https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&fields=id,name,webViewLink,webContentLink", {
						method: 'POST',
						headers: new Headers({ "Authorization": "Bearer " + gapi.auth.getToken().access_token }),
						body: formData
					}).then(function (response) {
						return response.json();
					}).then(function (value) {
						console.log(value);
						localStorage.setItem('file_id', value.id);
						localStorage.setItem('file_name', value.name);
						localStorage.setItem('file_viewLink', value.webViewLink);
						localStorage.setItem('file_downloadLink', value.webContentLink);
						document.cookie = "file_id=" + value.id;
						document.cookie = "file_name=" + value.name;
						document.cookie = "view_link=" + value.webViewLink;
						document.cookie = "download_link=" + value.webContentLink;
					});
				}
			}).catch((error) => {
				console.error('Error checking file existence:', error);
			});
			break;
		case "CVMBS":
			var fileName = selectedFile.name;
			var parent = '1JLQ7RBz41Z72CBdcrFKkrjHyCzQbcnlE';
			gapi.client.drive.files.list({
				q: `name='${fileName}' and '${parent}' in parents`,
				spaces: 'drive',
			}).then((response) => {
				const files = response.result.files;
        		if (files && files.length > 0) {
					alert("File: " + selectedFile.name + " already exists in the database.");
				} else {
					var metadata = {
						'name': fileName,
						'mimeType': selectedFile.type,
						'parents': ['1JLQ7RBz41Z72CBdcrFKkrjHyCzQbcnlE']
					};
					var formData = new FormData();
					formData.append("metadata", new Blob([JSON.stringify(metadata)], { type: 'application/json' }));
					formData.append("file", selectedFile);
					fetch("https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&fields=id,name,webViewLink,webContentLink", {
						method: 'POST',
						headers: new Headers({ "Authorization": "Bearer " + gapi.auth.getToken().access_token }),
						body: formData
					}).then(function (response) {
						return response.json();
					}).then(function (value) {
						console.log(value);
						localStorage.setItem('file_id', value.id);
						localStorage.setItem('file_name', value.name);
						localStorage.setItem('file_viewLink', value.webViewLink);
						localStorage.setItem('file_downloadLink', value.webContentLink);
						document.cookie = "file_id=" + value.id;
						document.cookie = "file_name=" + value.name;
						document.cookie = "view_link=" + value.webViewLink;
						document.cookie = "download_link=" + value.webContentLink;
					});
				}
			}).catch((error) => {
				console.error('Error checking file existence:', error);
			});
			break;
		case "College of Medicine":
			var fileName = selectedFile.name;
			var parent = '1-adk4eqga1fBQLTReLIKP_eBTUTzF81v';
			gapi.client.drive.files.list({
				q: `name='${fileName}' and '${parent}' in parents`,
				spaces: 'drive',
			}).then((response) => {
				const files = response.result.files;
        		if (files && files.length > 0) {
					alert("File: " + selectedFile.name + " already exists in the database.");
				} else {
					var metadata = {
						'name': fileName,
						'mimeType': selectedFile.type,
						'parents': ['1-adk4eqga1fBQLTReLIKP_eBTUTzF81v']
					};
					var formData = new FormData();
					formData.append("metadata", new Blob([JSON.stringify(metadata)], { type: 'application/json' }));
					formData.append("file", selectedFile);
					fetch("https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&fields=id,name,webViewLink,webContentLink", {
						method: 'POST',
						headers: new Headers({ "Authorization": "Bearer " + gapi.auth.getToken().access_token }),
						body: formData
					}).then(function (response) {
						return response.json();
					}).then(function (value) {
						console.log(value);
						localStorage.setItem('file_id', value.id);
						localStorage.setItem('file_name', value.name);
						localStorage.setItem('file_viewLink', value.webViewLink);
						localStorage.setItem('file_downloadLink', value.webContentLink);
						document.cookie = "file_id=" + value.id;
						document.cookie = "file_name=" + value.name;
						document.cookie = "view_link=" + value.webViewLink;
						document.cookie = "download_link=" + value.webContentLink;
					});
				}
			}).catch((error) => {
				console.error('Error checking file existence:', error);
			});
			break;
		case "Graduate School and Open Learning College":
			var fileName = selectedFile.name;
			var parent = '1YG4Z0wpBu0X2b4t78yhQ2un4YxyKjc27';
			gapi.client.drive.files.list({
				q: `name='${fileName}' and '${parent}' in parents`,
				spaces: 'drive',
			}).then((response) => {
				const files = response.result.files;
        		if (files && files.length > 0) {
					alert("File: " + selectedFile.name + " already exists in the database.");
				} else {
					var metadata = {
						'name': fileName,
						'mimeType': selectedFile.type,
						'parents': ['1YG4Z0wpBu0X2b4t78yhQ2un4YxyKjc27']
					};
					var formData = new FormData();
					formData.append("metadata", new Blob([JSON.stringify(metadata)], { type: 'application/json' }));
					formData.append("file", selectedFile);
					fetch("https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&fields=id,name,webViewLink,webContentLink", {
						method: 'POST',
						headers: new Headers({ "Authorization": "Bearer " + gapi.auth.getToken().access_token }),
						body: formData
					}).then(function (response) {
						return response.json();
					}).then(function (value) {
						console.log(value);
						localStorage.setItem('file_id', value.id);
						localStorage.setItem('file_name', value.name);
						localStorage.setItem('file_viewLink', value.webViewLink);
						localStorage.setItem('file_downloadLink', value.webContentLink);
						document.cookie = "file_id=" + value.id;
						document.cookie = "file_name=" + value.name;
						document.cookie = "view_link=" + value.webViewLink;
						document.cookie = "download_link=" + value.webContentLink;
					});
				}
			}).catch((error) => {
				console.error('Error checking file existence:', error);
			});
			break;
		case "General":
			var fileName = selectedFile.name;
			var parent = '1cS_xmX5ct0FV4bP9LZfDlc_vd72ZYpPZ';
			gapi.client.drive.files.list({
				q: `name='${fileName}' and '${parent}' in parents`,
				spaces: 'drive',
			}).then((response) => {
				const files = response.result.files;
        		if (files && files.length > 0) {
					alert("File: " + selectedFile.name + " already exists in the database.");
				} else {
					var metadata = {
						'name': fileName,
						'mimeType': selectedFile.type,
						'parents': ['1cS_xmX5ct0FV4bP9LZfDlc_vd72ZYpPZ']
					};
					var formData = new FormData();
					formData.append("metadata", new Blob([JSON.stringify(metadata)], { type: 'application/json' }));
					formData.append("file", selectedFile);
					fetch("https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&fields=id,name,webViewLink,webContentLink", {
						method: 'POST',
						headers: new Headers({ "Authorization": "Bearer " + gapi.auth.getToken().access_token }),
						body: formData
					}).then(function (response) {
						return response.json();
					}).then(function (value) {
						console.log(value);
						localStorage.setItem('file_id', value.id);
						localStorage.setItem('file_name', value.name);
						localStorage.setItem('file_viewLink', value.webViewLink);
						localStorage.setItem('file_downloadLink', value.webContentLink);
						document.cookie = "file_id=" + value.id;
						document.cookie = "file_name=" + value.name;
						document.cookie = "view_link=" + value.webViewLink;
						document.cookie = "download_link=" + value.webContentLink;
					});
				}
			}).catch((error) => {
				console.error('Error checking file existence:', error);
			});
			break;
		default:
			console.log(metadata);
	}
}

async function deleteFile(fileId) {
	const accessToken = gapi.client.getToken().access_token;

	const url = 'https://www.googleapis.com/drive/v3/files/' + fileId;
	return await fetch(url, {
		method: 'DELETE',
		headers: {
		'Authorization': 'Bearer ' + accessToken
		}
	}).then(function (response) {
		console.log('The file has been deleted.', fileId);
	}).then(function (value) {
        console.log(value);
	});
}

function removeFromDb(fileId) {
	$.ajax({
        type: 'POST',
        url: 'delete.php',
        data: { 'fileId': fileId },
        success: function(response) {
            console.log(response);
			alert("The file has been deleted successfully.");
			window.location.reload();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function removeUser(id) {
	$.ajax({
        type: 'POST',
        url: 'delete_user.php',
        data: { 'id': id },
        success: function(response) {
            console.log(response);
			alert("The user has been deleted successfully.");
			window.location.reload();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function removeUserRequest(id) {
	$.ajax({
        type: 'POST',
        url: 'delete_request.php',
        data: { 'id': id },
        success: function(response) {
            console.log(response);
			alert("The user access request has been removed.");
			window.location.reload();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}