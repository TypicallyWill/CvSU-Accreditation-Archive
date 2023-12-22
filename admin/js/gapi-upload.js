// TODO: Set the below credentials
const CLIENT_ID = '75132863473-h6i0tqj5tuc7jbm6ptjgrlb7snvv8im6.apps.googleusercontent.com';
const CLIENT_SECRET = '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';

// Discovery URL for APIs used by the quickstart
const DISCOVERY_DOC = 'https://www.googleapis.com/discovery/v1/apis/drive/v3/rest';

const KEYFILEPATH = 'C:\\xampp\\htdocs\\cvsu_accrsystem\\cvsu-accreditation-37a00b400711.json';

// Set API access scope before proceeding authorization request
const SCOPES = 'https://www.googleapis.com/auth/drive.file';
let tokenClient;
let gapiInited = false;
let gisInited = false;

/**
 * Callback after api.js is loaded.
 */
function gapiLoaded() {
	gapi.load('client', initializeGapiClient);
}

/**
 * Callback after the API client is loaded. Loads the
 * discovery doc to initialize the API.
 */
async function initializeGapiClient() {
	await gapi.client.init({
		client_secret: CLIENT_SECRET,
		discoveryDocs: [DISCOVERY_DOC],
	});
	gapiInited = true;
	maybeEnableButtons();
}

/**
 * Callback after Google Identity Services are loaded.
 */
function gisLoaded() {
	tokenClient = google.accounts.oauth2.initTokenClient({
		client_id: CLIENT_ID,
		scope: SCOPES, 
		callback: '', // defined later
	});
	gisInited = true;
	maybeEnableButtons();
}

/**
 * Enables user interaction after all libraries are loaded.
 */
function maybeEnableButtons() {
	if (gapiInited && gisInited) {
		//document.getElementById('authorize_button').style.visibility = 'visible';
	}
}

/**
 *  Sign in the user upon button click.
 */
function handleAuthClick() {
	tokenClient.callback = async (resp) => {
		if (resp.error !== undefined) {
			throw (resp);
		}
		document.getElementById('signout_button').style.visibility = 'visible';
        document.getElementById('authorize_button').style.visibility = 'hidden';
        document.getElementById('fileInput').style.visibility = 'visible';
		document.getElementById('uploadButton').style.visibility = 'visible';
		//await uploadFile();

	};

	if (gapi.client.getToken() === null) {
		// Prompt the user to select a Google Account and ask for consent to share their data
		// when establishing a new session.
		tokenClient.requestAccessToken({ prompt: 'consent' });
	} else {
		// Skip display of account chooser and consent dialog for an existing session.
		tokenClient.requestAccessToken({ prompt: '' });
	}
}

/**
 *  Sign out the user upon button click.
 */
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
			var metadata = {
				'name': selectedFile.name, // Filename at Google Drive
				'mimeType': selectedFile.type, // mimeType at Google Drive
				'parents': ['1TOtgbbPoKIr3JZNyVfP4D6SJdYf3aOW_'] // Folder ID at Google Drive
			};
			break;
		case "CAS":
			var metadata = {
				'name': selectedFile.name,
				'mimeType': selectedFile.type,
				'parents': ['1_iD1SgmR0j842o0Oo0W2BOohmSf5tbGR']
			};
			break;
		case "CCJ":
			var metadata = {
				'name': selectedFile.name,
				'mimeType': selectedFile.type,
				'parents': ['1ulh8Z5zVz6iJzO0AXO6GAJQBbP2Dkm7g']
			};
			break;
		case "CED":
			var metadata = {
				'name': selectedFile.name,
				'mimeType': selectedFile.type,
				'parents': ['1prhnN8SQkVBmg2cO3Nq2RFZXoaYF3bXZ']
			};
			break;
		case "CEMDS":
			var metadata = {
				'name': selectedFile.name,
				'mimeType': selectedFile.type,
				'parents': ['1EGaDpuwOAqrJrP4vW5WhD5iWAMXQra1j']
			};
			break;
		case "CEIT":
			var metadata = {
				'name': selectedFile.name,
				'mimeType': selectedFile.type,
				'parents': ['1ShUNEQ9F_wN6Nxuyo-8y9j4JKig8dlmg']
			};
			break;
		case "CON":
			var metadata = {
				'name': selectedFile.name,
				'mimeType': selectedFile.type,
				'parents': ['1hqDXkWjvcsB0WKNYw_roijPj9eDTC8fn']
			};
			break;
		case "CSPEAR":
			var metadata = {
				'name': selectedFile.name,
				'mimeType': selectedFile.type,
				'parents': ['1fjGBBGdSEEZmxRIbVl8X-1zFvmIep51o']
			};
			break;
		case "CVMBS":
			var metadata = {
				'name': selectedFile.name,
				'mimeType': selectedFile.type,
				'parents': ['1JLQ7RBz41Z72CBdcrFKkrjHyCzQbcnlE']
			};
			break;
		case "College of Medicine":
			var metadata = {
				'name': selectedFile.name,
				'mimeType': selectedFile.type,
				'parents': ['1-adk4eqga1fBQLTReLIKP_eBTUTzF81v']
			};
			break;
		case "Graduate School and Open Learning College":
			var metadata = {
				'name': selectedFile.name,
				'mimeType': selectedFile.type,
				'parents': ['1YG4Z0wpBu0X2b4t78yhQ2un4YxyKjc27']
			};
			break;
		default:
			alert('No file directory selected.');
			var metadata = {
				'name': selectedFile.name,
				'mimeType': selectedFile.type,
				'parents': ['1cS_xmX5ct0FV4bP9LZfDlc_vd72ZYpPZ']
			};
	}
	
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
        // file is uploaded
		document.getElementById('content').innerHTML = "File uploaded successfully. The Google Drive file ID is <b>" + value.id + value.name + value.webViewLink + value.webContentLink;
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

async function deleteFile(fileId) {

	const accessToken = gapi.client.getToken().access_token;

	const url = 'https://www.googleapis.com/drive/v3/files/' + fileId;
	return await fetch(url, {
		method: 'DELETE',
		headers: {
		'Authorization': 'Bearer ' + accessToken
		}
	}).then(function (response) {
		return response.json();
	}).then(function (value) {
        console.log(value);
	});

	/*var xhr = new XMLHttpRequest();
	var boundary = "END_OF_PART";
	var separation = "\n--"+boundary + "\n";

	var requestBody = ()=>{
		separation +
		"Content-Type: application/http\n\n" +
		"DELETE https://www.googleapis.com/drive/v3/files/" +
		fileId +
		"\nAuthorization: Bearer " + accessToken;
		};

	/*xmlReq.open('DELETE', 'https://www.googleapis.com/drive/v3/files/' + fileId);
	xmlReq.setRequestHeader('Authorization', 'Bearer ' + accessToken);

	xmlReq.onload = ()=> {
		console.log(xmlReq.response);
	};*/

	/*xhr.onload = ()=>{
		console.log(xhr.response);
		//handle the response
	};*/
	/*xhr.open("DELETE", "https://www.googleapis.com/drive/v3/files/" + {fileId}, true);
	xhr.setRequestHeader('Authorization', 'Bearer ' + accessToken);
	//xhr.send(requestBody);

	xhr.onload = ()=>{
		console.log(xhr.response);
		//handle the response
	};*/

	//var xmlReq = new XMLHttpRequest();
	//xmlReq.open('DELETE', 'https://www.googleapis.com/drive/v3/files/' + fileId);
	//xmlReq.setRequestHeader('Authorization', 'Bearer ' + gapi.auth.getToken().access_token);
}