// Flutter - upload_cv.dart
Future<void> uploadCV(File cvFile) async {
  var request = http.MultipartRequest(
    'POST', 
    Uri.parse('${baseUrl}/api/v1/cv/upload')
  );
  
  request.files.add(await http.MultipartFile.fromPath(
    'cv_file', 
    cvFile.path
  ));
  
  request.fields['user_id'] = userId;
  request.fields['target_position'] = targetPosition;
  
  var response = await request.send();
  var responseData = await http.Response.fromStream(response);
  
  var result = json.decode(responseData.body);
  // Result berisi: skill_gap_analysis, recommendations, roadmap
}