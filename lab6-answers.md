# Lab 6 — my answers

Name: Wesley Ndwiga Njerenga · Admission number: 209593

1. PHP checks the values again because browser validation can be bypassed with developer tools or a direct request. Server-side validation ensures invalid member numbers, dates, sessions, or litres are not accepted.

2. In `bind_param('issd', ...)`, `i` means an integer for the farmer ID, `s` means a string for the delivery date and session, and `d` means a double for litres. The four letters correspond in order to the four `?` placeholders.

3. Delete uses a POST form because it changes or removes data and should not run when someone simply opens or follows a link. Edit uses a link to open an editable view for one delivery, and the form on that page sends the save request by POST.

4. The injected text becomes the value of the `date` parameter. The prepared statement sends it as a string through `bind_param`, separate from the SQL, so it does not become SQL syntax and normally matches no delivery.
