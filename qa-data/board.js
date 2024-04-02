window.onload = function() {
    var backBtn = document.getElementById("back-to-start");
    var firstQBtn = document.getElementById("first-question");
    var nextQBtn = document.getElementById("next-question");
    var prevQBtn = document.getElementById("previous-question");
    
    if (typeof(backBtn) != 'undefined' && backBtn != null) {
        backBtn.onclick = function() {
            window.location.replace("?");
        }
        document.addEventListener('keydown', function(event) {
            if (event.key === 'ArrowLeft') {
                window.location.replace("?");
            }
        });
    }

    if (typeof(firstQBtn) != 'undefined' && firstQBtn != null) {
        firstQBtn.onclick = function() {
            window.location.replace("?question=1");
        }
        document.addEventListener('keydown', function(event) {
            if (event.key === 'ArrowRight') {
                window.location.replace("?question=1");
            }
        });
    }

    if (typeof(nextQBtn) != 'undefined' && nextQBtn != null) {
        nextQBtn.onclick = function() {
            const searchParams = new URLSearchParams(window.location.search);
            var next = parseInt(searchParams.get('question')) + 1;
            window.location.replace("?question=" + next);
        }
        document.addEventListener('keydown', function(event) {
            if (event.key === 'ArrowRight') {
                const searchParams = new URLSearchParams(window.location.search);
                var next = parseInt(searchParams.get('question')) + 1;
                window.location.replace("?question=" + next);
            }
        });
    }

    if (typeof(prevQBtn) != 'undefined' && prevQBtn != null) {
        prevQBtn.onclick = function() {
            const searchParams = new URLSearchParams(window.location.search);
            var prev = parseInt(searchParams.get('question')) - 1;
            window.location.replace("?question=" + prev);
        }
        document.addEventListener('keydown', function(event) {
            if (event.key === 'ArrowLeft') {
                const searchParams = new URLSearchParams(window.location.search);
                var prev = parseInt(searchParams.get('question')) - 1;
                window.location.replace("?question=" + prev);
            }
        });
    }
}