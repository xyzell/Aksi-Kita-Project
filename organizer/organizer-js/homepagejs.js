// comma between zero
function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

// error 8 campaigns
function eightCampaigns() {
  Swal.fire({
  icon: "error",
  title: "Error!",
  text: "You Have Already Reached The Limit of Campaings You Can Create",
  buttonsStyling: false,
  customClass: {
    title: 'title-modal',
    text: 'text-modal',
    confirmButton: 'btn rounded-pill border-0 bg-warning bg-opacity-75 h-button mt-2 fw-bolder fs-6 text-white button-modal'
  }
});
}