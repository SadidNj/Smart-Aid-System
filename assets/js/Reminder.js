function validateMedicineReminder(){
  var med = document.getElementById('medicine').value.trim();
  var time = document.getElementById('time').value.trim();
  if(!med || !time){ alert('Please fill required fields.'); return false; }
  return true;
}
