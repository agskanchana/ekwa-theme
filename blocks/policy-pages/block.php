<?php
// Ensure your dynamic practice name is URL-encoded in PHP.
$practice_name = get_theme_mod('practise_name');
$encoded_practice_name = urlencode($practice_name);
$site_domain = home_url();
$address = urlencode(get_location('street_address'));
$city = urlencode(get_location('city'));
$state = urlencode(get_location('state'));
$zip = urlencode(get_location('zip'));
$email = urlencode(get_theme_mod('email_address'));

// Conditionally set the phone number.
if(isset($_COOKIE['adward_number']) || isset($_GET['ads'])) {
  $phone_num = get_theme_mod('adsense_number');
} else {
  $phone_num = get_theme_mod('call_tracking_number');
}
?>

<div id="policy_page_content"></div>

<script>
// JavaScript part to handle fetching the data
var policy_container = document.querySelector("#policy_page_content");
var myHeaders = new Headers();
myHeaders.append("Content-Type", "application/json");
var requestOptions = {
  method: 'GET',
  headers: myHeaders,
  redirect: 'follow'
};

// PHP dynamically inserted values into JavaScript
var practiceName = "<?php echo esc_js($encoded_practice_name); ?>";
var siteDomain = "<?php echo esc_js($site_domain); ?>";
var address = "<?php echo esc_js($address); ?>";
var city = "<?php echo esc_js($city); ?>";
var state = "<?php echo esc_js($state); ?>";
var zip = "<?php echo esc_js($zip); ?>";
var email = "<?php echo esc_js($email); ?>";
var phoneNum = "<?php echo esc_js($phone_num); ?>";

// Constructing the URL dynamically with encoded parameters
var url = "https://policies.ekwa.com/wp-json/ws/v1/policy_page?" +
  "id=<?php echo intval(get_field('select-policy-page')); ?>" +
  "&bussiness_name=" + encodeURIComponent(practiceName) +
  "&phone=" + encodeURIComponent(phoneNum) +
  "&country=<?php echo esc_js(get_theme_mod('country')); ?>" +
  "&domain=" + encodeURIComponent(siteDomain) +
  "&address=" + encodeURIComponent(address) +
  "&city=" + encodeURIComponent(city) +
  "&state=" + encodeURIComponent(state) +
  "&zip=" + encodeURIComponent(zip) +
  "&email=" + encodeURIComponent(email);

// Fetch the policy content based on the URL
fetch(url)
  .then(response => response.text())
  .then(result => {
    policy_container.innerHTML = JSON.parse(result);
  })
  .catch(error => console.log('error', error));
</script>
