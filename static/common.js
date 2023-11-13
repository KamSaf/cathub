// $(document).ready(function() {
//     $(".delete-post-button").click(function() {
//         var postId = $(this).data("postId");

//         if (confirm("Are you sure you want to delete this post?")) {
//             $.ajax({
//                 type: "POST",
//                 url: "/cathub/routes/actions/delete_post.php",
//                 data: {
//                     postId: postId
//                 },
//                 success: function(response) {
//                     $("#post_" + postId).remove();
//                     $('#confirmDeleteModal').modal('hide');
//                 }
//             });
//         }
//     });
// });



$(document).ready(function() {
    $(".delete-post-button").click(function() {
      var postId = $(this).data("postId");

      // Ustaw postId w modalu
      $("#delete_post_button").data("postId", postId);

      // Pokaż modal
      $('#confirm_delete_modal').modal('show');
    });

    $("#delete_post_button").click(function() {
      var postId = $(this).data("postId");

      // Wywołaj żądanie AJAX do usunięcia postu
      $.ajax({
        type: "POST",
        url: "/cathub/routes/actions/delete_post.php",
        data: {
          postId: postId
        },
        success: function(response) {
          // Usuń post po otrzymaniu odpowiedzi
          $("#post_" + postId).remove();
          $('#confirm_delete_modal').modal('hide'); // Ukryj modal
        }
      });
    });
  });