$().ready(function() {
	$( "#add-selection" ).slideUp("fast");
	$( "#add-notification" ).slideUp("fast");
	$( "#add-web-form" ).slideUp("fast");
	$( "#add-upload-form" ).slideUp("fast");
	$( "#add-board-form" ).slideUp("fast");
	$( "#add-stream-form" ).slideUp("fast");
	$( "#add-follow-form" ).slideUp("fast");
	$( "#add-pin" ).click(function() {
	  $( "#add-selection" ).slideToggle(500,function() {
	    // Animation complete.
	  });
	  $( "#add-web-form" ).slideUp();
	  $( "#add-upload-form" ).slideUp();
	  $( "#add-board-form" ).slideUp();
	  $( "#add-follow-form" ).slideUp();
	  $( "#add-stream-form" ).slideUp();
	});
	$("#not-btn").click(function(){
		$( "#add-notification" ).slideToggle(500);
	});
	$( "#add-web" ).click(function() {
	  $( "#add-selection" ).slideToggle(500,function() {
	    // Animation complete.
	  });
	  $( "#add-web-form" ).slideToggle(500,function() {
	    // Animation complete.
	  });
	}); 
	$( "#add-upload" ).click(function() {
	  $( "#add-selection" ).slideToggle(500,function() {
	    // Animation complete.
	  });
	  $( "#add-upload-form" ).slideToggle(500,function() {
	    // Animation complete.
	  });
	}); 
	$( "#add-board" ).click(function() {
	  $( "#add-selection" ).slideToggle(500,function() {
	    // Animation complete.
	  });
	  $( "#add-board-form" ).slideToggle(500,function() {
	    // Animation complete.
	  });
	});
	$( "#add-stream" ).click(function() {
	  $( "#add-selection" ).slideToggle(500,function() {
	    // Animation complete.
	  });
	  $( "#add-stream-form" ).slideToggle(500,function() {
	    // Animation complete.
	  });
	});
	$( "#add-follow" ).click(function() {
	  $( "#add-selection" ).slideToggle(500,function() {
	    // Animation complete.
	  });
	  $( "#add-follow-form" ).slideToggle(500,function() {
	    // Animation complete.
	  });
	});
	$( "#close-web-form" ).click(function() {
	  $( "#add-web-form" ).slideUp(500,function() {
	    // Animation complete.
	  });
	});
	$( "#close-board-form" ).click(function() {
	  $( "#add-board-form" ).slideUp(500,function() {
	    // Animation complete.
	  });
	});
	$( "#close-upload-form" ).click(function() {
	  $( "#add-upload-form" ).slideUp(500,function() {
	    // Animation complete.
	  });
	});
	$( "#close-stream-form" ).click(function() {
	  $( "#add-stream-form" ).slideUp(500,function() {
	    // Animation complete.
	  });
	});
	$( "#close-follow-form" ).click(function() {
	  $( "#add-follow-form" ).slideUp(500,function() {
	    // Animation complete.
	  });
	});

	//for follow stream
	$( "#pin-stream-board" ).slideUp();
	$( "#see-stream-board" ).click(function() {
	  $( "#pin-stream-tag" ).slideUp( "fast", function() {
	    // Animation complete.
	  });
	  $( "#pin-stream-board" ).slideDown( "fast", function() {
	    // Animation complete.
	  });
	});
	$( "#see-stream-tag" ).click(function() {
	  $( "#pin-stream-board" ).slideUp( "fast", function() {
	    // Animation complete.
	  });
	  $( "#pin-stream-tag" ).slideDown( "fast", function() {
	    // Animation complete.
	  });
	});
	$( "#signinbox" ).click(function() {
	  $( "#login-box" ).slideToggle(500,function() {
	    // Animation complete.
	  });
	}); 
});