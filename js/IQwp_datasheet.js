jQuery(document).ready(function () {

    var ref = document.URL;
    var IQhostid = get_host();
    var IQassetid = get_assetid();
    var IQmaximages = get_IQmaximages();
    var IQshowthmbnails = get_IQshowthmbnails();
    var IQshowaboutreviews = get_IQshowaboutreviews();
    var IQshowassetname = get_IQshowassetname();
    var IQshowprices = get_IQshowprices();
    var IQshowdescription = get_IQshowdescription();
    var IQshowimages = get_IQshowimages();
    var IQshowvideo = get_IQshowvideo();
    var IQshowassetmetadata = get_IQshowassetmetadata();

if (!jQuery.isNumeric(IQassetid) ) {
	window.alert('The asset id is not a number in the shortcode on the page. \nAdd the id of your asset to the shortcode. \nDo not use a space after assetid= .');
	return;
}
if (!jQuery.isNumeric(IQhostid) ) {
	window.alert('The Host id is not a number in the shortcode on the page. \nAdd the id of your host to the shortcode. \nDo not use a space after hostid= .');
	return;
}
if (!jQuery.isNumeric(IQmaximages) ) {
	window.alert('The value for maximum number of images is incorrect or not set. \nPlease ensure you have saved the configuration.');
	return;
}


    var jsondata = { 'IQhostid': IQhostid, 'IQassetid': IQassetid, 'IQmaximages': IQmaximages, 'IQshowthmbnails': IQshowthmbnails, 'IQshowaboutreviews': IQshowaboutreviews, 'IQshowassetname': IQshowassetname, 'IQshowprices': IQshowprices, 'IQshowdescription': IQshowdescription, 'IQshowimages': IQshowimages, 'IQshowvideo': IQshowvideo, 'IQshowassetmetadata': IQshowassetmetadata };
    jsondata = JSON.stringify(jsondata);


    jQuery.ajaxPrefilter('json', function (options, orig, jqXHR) {
        if (options.crossDomain && !jQuery.support.cors) {
            return 'jsonp';
        }
    });
    jQuery.ajax({
        type: 'POST',
        url: 'https://www.instant-quote.co/webservices/wp_datasheet.ashx/wp_datasheet/ProcessRequest',
        contentType: 'application/json; charset=utf-8',
        crossDomain: true,
        dataType: 'json',
        data: jsondata,
        beforeSend: function () {
            if (!!document.getElementById('IQremoteInfo')) {
                document.getElementById('IQremoteInfo').innerHTML = 'Loading datasheet';
            }
        },
        success: InitComplete,
        error: InitFail
    });

});


function InitFail(result) {
    window.alert('Error: ' + result.responseText);
    if (!!document.getElementById('IQremoteInfo')) {
        document.getElementById('IQremoteInfo').innerHTML = 'Error loading page data.';
    }
}

function InitComplete(result) {

    document.querySelector('head').innerHTML += result.stylelink;

    if (!!document.getElementById('IQremoteAssethtml')) {
        document.getElementById('IQremoteAssethtml').innerHTML = result.assethtml;
    }
    if (!!document.getElementById('IQremoteAssetTitle')) {
        document.getElementById('IQremoteAssetTitle').innerHTML = result.assettitle;
    }
    if (!!document.getElementById('IQremoteAssetMainImage')) {
        document.getElementById('IQremoteAssetMainImage').innerHTML = result.assetimage;
    }
    if (!!document.getElementById('IQremoteAssetThumbs')) {
        document.getElementById('IQremoteAssetThumbs').innerHTML = result.assetthumbs;
    }
    if (!!document.getElementById('IQassetvideothumb')) {
        document.getElementById('IQassetvideothumb').innerHTML = result.assetvideolinks;
    }
    if (!!document.getElementById('IQremoteAssetDescription')) {
        document.getElementById('IQremoteAssetDescription').innerHTML = result.description;
    }
    if (!!document.getElementById('IQremoteAssetPackage')) {
        document.getElementById('IQremoteAssetPackage').innerHTML = result.packagecontents;
    }	
    if (!!document.getElementById('IQremoteAssetPriceSummary')) {
        document.getElementById('IQremoteAssetPriceSummary').innerHTML = result.assetprices;
    }
    if (!!document.getElementById('IQremoteAssetDataSummary')) {
        document.getElementById('IQremoteAssetDataSummary').innerHTML = result.assetdata;
    }
    if (!!document.getElementById('IQremoteassetreview')) {
        document.getElementById('IQremoteassetreview').innerHTML = result.reviewhtml;
    }

    // Clear the loading message
    if (!!document.getElementById('IQremoteInfo')) {
        document.getElementById('IQremoteInfo').innerHTML = '';
    }
}

function get_host() {
    var hf = document.getElementById('IQhost');
    if (!hf) {
        hf = document.getElementById('MainContent_IQhost');
    }
    if (!!hf) {
        return (hf.value);
    }
    else {
        return (0);
    }
}

function get_assetid() {
    var hf = document.getElementById('IQassetid');
    if (!hf) {
        hf = document.getElementById('MainContent_IQassetid');
    }
    if (!!hf) {
        return (hf.value);
    }
    else {
        return (0);
    }
}

function get_IQmaximages() {
    var hf = document.getElementById('IQmaximages');
    if (!hf) {
        hf = document.getElementById('MainContent_IQmaximages');
    }
    if (!!hf) {
        return (hf.value);
    }
    else {
        return (0);
    }
}

function get_IQshowthmbnails() {
    var hf = document.getElementById('IQshowthmbnails');
    if (!hf) {
        hf = document.getElementById('MainContent_IQshowthmbnails');
    }
    if (!!hf) {
		var ret = false;
		if (hf.value === 'on') {ret = true;}
        return (ret);
    }
    else {
        return (false);
    }
}

function get_IQshowaboutreviews() {
    var hf = document.getElementById('IQshowaboutreviews');
    if (!hf) {
        hf = document.getElementById('MainContent_IQshowaboutreviews');
    }
    if (!!hf) {
		var ret = false;
		if (hf.value === 'on') {ret = true;} 
        return (ret);
    }
    else {
        return (false);
    }
}

function get_IQshowassetname() {
    var hf = document.getElementById('IQshowassetname');
    if (!hf) {
        hf = document.getElementById('MainContent_IQshowassetname');
    }
    if (!!hf) {
		var ret = false;
		if (hf.value === 'on') {ret = true;}
        return (ret);
    }
    else {
        return (false);
    }
}

function get_IQshowprices() {
    var hf = document.getElementById('IQshowprices');
    if (!hf) {
        hf = document.getElementById('MainContent_IQshowprices');
    }
    if (!!hf) {
		var ret = false;
		if (hf.value === 'on') {ret = true;}
        return (ret);
    }
    else {
        return (false);
    }
}

function get_IQshowdescription() {
    var hf = document.getElementById('IQshowdescription');
    if (!hf) {
        hf = document.getElementById('MainContent_IQshowdescription');
    }
    if (!!hf) {
		var ret = false;
		if (hf.value === 'on') {ret = true;}
        return (ret);
    }
    else {
        return (false);
    }
}

function get_IQshowimages() {
    var hf = document.getElementById('IQshowimages');
    if (!hf) {
        hf = document.getElementById('MainContent_IQshowimages');
    }
    if (!!hf) {
		var ret = false;
		if (hf.value === 'on') {ret = true;}
        return (ret);
    }
    else {
        return (false);
    }
}

function get_IQshowvideo() {
    var hf = document.getElementById('IQshowvideo');
    if (!hf) {
        hf = document.getElementById('MainContent_IQshowvideo');
    }
    if (!!hf) {
		var ret = false;
		if (hf.value === 'on') {ret = true;} 
        return (ret);
    }
    else {
        return (false);
    }
}

function get_IQshowassetmetadata() {
    var hf = document.getElementById('IQshowassetmetadata');
    if (!hf) {
        hf = document.getElementById('MainContent_IQshowassetmetadata');
    }
    if (!!hf) {
		var ret = false;
		if (hf.value === 'on') {ret = true;}
        return (ret);
    }
    else {
        return (false);
    }
}

function swapimage(img) {

    var img_elem = document.getElementById('main_asset_img');
    if (!!img_elem) {
        img_elem.src = img.src.replace('/medium/', '/large/');
    }
}