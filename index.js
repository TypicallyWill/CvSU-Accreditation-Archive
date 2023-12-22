const {google} = require('googleapis');
const path = require('path')
const fs = require('fs')
const targetFolderId = '1cS_xmX5ct0FV4bP9LZfDlc_vd72ZYpPZ'

const CLIENT_ID = '75132863473-h6i0tqj5tuc7jbm6ptjgrlb7snvv8im6.apps.googleusercontent.com';
const CLIENT_SECRET = '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';

const KEYFILEPATH = 'C:\\xampp\\htdocs\\cvsu_accrsystem\\cvsu-accreditation-37a00b400711.json';

const SCOPES = ['https://www.googleapis.com/auth/drive'];

const auth = new google.auth.GoogleAuth( {
    keyFile: KEYFILEPATH,
    scopes: SCOPES
})

const driveService = google.drive( {
    version: 'v3',
    auth
})

//Upload specific file
async function uploadFile (auth) {

    let fileMetaData = {
        name: 'Test File.pdf',
        parents: [targetFolderId]
    }

    let media = {
        mimeType: 'application/pdf',
        body: fs.createReadStream('test_file.pdf')
    }

    let response = await driveService.files.create( {
        resource: fileMetaData,
        media: media
    })

    switch(response.status) {
        case 200:
            console.log(response.data)
            break;

        default:
            console.error('Error uploading file, ' + response.errors)
            break;
    }
}

//uploadFile(auth);

//Delete specific file
async function deleteFile (auth) {
    try {
        const response = await driveService.files.delete({
            fileId: '1j0zVdcPnqWZHKkf7H0iHxwQGKCeDvNO2',
        });

        console.log(response.data, response.status);

    } catch (error) {
        console.error('Error deleting file, ' + error.message);
    }
}

//deleteFile(auth);

//Get Public URLs for specific file
async function generatePublicUrl (auth) {
    try {
        const fileId = '1852QyLG3BOGFgLn0u84MPSRLm1WqFo4p';
        await driveService.permissions.create({
            fileId: fileId,
            requestBody: {
                role: 'reader',
                type: 'anyone'
            }
        })

        //webContentLink is download link, webViewLink is for view link
        const result = await driveService.files.get({
            fileId: fileId,
            fields: 'webViewLink, webContentLink, name'
        })

        console.log(result.data);
        console.log(result.data.webContentLink, result.data.webViewLink, result.data.name);

    } catch (error) {
        console.log(error.message);
    }
}

generatePublicUrl(auth);