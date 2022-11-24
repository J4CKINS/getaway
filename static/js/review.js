let ratingScore = document.getElementById("rating-score");
let ratingStars = document.getElementsByClassName("rating-star");
let setRating = (score) => {
    ratingScore.value = score;
    updateRatingStars(score);
    console.log(ratingScore.value);
}
let updateRatingStars = (score) => {
    for(x = 0; x < ratingStars.length; x++) {
        if (x < score) {
            ratingStars[x].src = "/static/img/icons/star_full.svg";
        } else {
            ratingStars[x].src = "/static/img/icons/star_empty.svg";
        }
    }
}