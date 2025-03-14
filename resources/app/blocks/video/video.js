document.addEventListener("DOMContentLoaded", function () {
  if (document.querySelector("[data-video-play]")) {
    const btnsPlayVideo = document.querySelectorAll("[data-video-play]");

    btnsPlayVideo.forEach((btn) => {
      btn.addEventListener("click", () => {
        const videoWrap = btn.closest("[data-video-wrap]");
        const video = videoWrap.querySelector("[data-video]");
        const videoPreview = videoWrap.querySelector("[data-video-preview]");

        fadeOut({
          el: btn,
          timeout: 500,
        });

        if (videoPreview) {
          fadeOut({
            el: videoPreview,
            timeout: 500,
          });
        }

        videoWrap.classList.remove("video--overlay");
        video.setAttribute(
          "src",
          `${video.getAttribute("src") + "?autoplay=1"}`
        );
      });
    });
  }
});
