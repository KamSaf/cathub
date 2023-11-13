$(document).ready(function() {
    $(".delete-post-button").click(function() {
      var postId = $(this).data("postId");

      $("#delete_item_button").data("postId", postId);

      $('#confirm_delete_modal').modal('show');
    });

    $("#delete_item_button").click(function() {
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


$(document).ready(function() {
  $(".delete-comment-button").click(function() {
    var commentId = $(this).data("commentId");

    $("#delete_item_button").data("commentId", commentId);

    $('#confirm_delete_modal').modal('show');
  });

  $("#delete_item_button").click(function() {
    var commentId = $(this).data("commentId");

    $.ajax({
      type: "POST",
      url: "/cathub/routes/actions/delete_comment.php",
      data: {
        commentId: commentId
      },
      success: function(response) {
        console.log(response);
        $("#comment_" + commentId).remove();
        $('#confirm_delete_modal').modal('hide');
      }
    });
  });
});


$(document).ready(function() {
    $(".react-button").click(function() {
      var postId = $(this).data("postId");
      var $this = $(this);
      $.ajax({
        type: "POST",
        url: "/cathub/routes/actions/react_post.php",
        data: {
          postId: postId
        },
        success: function(response) {
          let reactions = 0;
          if (JSON.parse(response).result === 'true'){
            $this.removeClass('btn-outline-success').addClass('btn-success');
            reactions = parseInt($('#reactions_' + postId).html()) + 1;
          } else if(JSON.parse(response).result === 'false'){
            $this.removeClass('btn-success').addClass('btn-outline-success');
            reactions = parseInt($('#reactions_' + postId).html()) - 1;
          }
          $('#reactions_' + postId).html(reactions);
        }
      });
    });
});