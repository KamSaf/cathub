$(document).ready(function() {
    $(".delete-post-button").click(function() {
      var postId = $(this).data("postId");

      $("#delete_post_button").data("postId", postId);

      $('#confirm_delete_modal').modal('show');
    });

    $("#delete_post_button").click(function() {
      var postId = $(this).data("postId");

      $.ajax({
        type: "POST",
        url: "/cathub/routes/actions/delete_post.php",
        data: {
          postId: postId
        },
        success: function(response) {
          $("#post_" + postId).remove();
          $('#confirm_delete_modal').modal('hide');
        }
      });
    });
  });