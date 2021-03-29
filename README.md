# Open Cart 3 Extension - Return Email Alert

Open Cart 3 does not send the store owner or additional mail recipients an email when customers create a return request. Additionally some versions of Open Cart 3 also fail to send Return History alerts due to a bug in the events setup in the sql table. This module has a SQL patch to resolve the Return History bug and additional mail controller to handle the store owner alert.

The Open Cart installer tool rejects changes to the mail folder so you have to upload files directly to your install or adjust the allowed directories to include 'catalog/controller/mail/' like below.

/admin/controller/marketplace/install.php around line 124

// A list of allowed directories to be written to
$allowed = array(
  'admin/controller/extension/',
  'admin/language/',
  'admin/model/extension/',
  'admin/view/image/',
  'admin/view/javascript/',
  'admin/view/stylesheet/',
  'admin/view/template/extension/',
  'catalog/controller/extension/',
  'catalog/controller/mail/',
  'catalog/language/',
  'catalog/model/extension/',
  'catalog/view/javascript/',
  'catalog/view/theme/',
  'system/config/',
  'system/library/',
  'image/catalog/'
);

As an additional note, there is a setting in Open Cart to track and show customer activity in the dashboard. You can enable this to allow new returns to appear on the main admin dashboard along with other useful information.