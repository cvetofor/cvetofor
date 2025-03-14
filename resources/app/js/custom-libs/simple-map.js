document.addEventListener("DOMContentLoaded", function () {
  let mapItem = document.querySelector("[data-map]");
  if (mapItem) {
    let mapOverlay = mapItem.closest("[data-map-overlay]");

    ymaps.ready(() => {
      initSimpleMap(mapItem);
    });

    if (mapOverlay) {
      mapOverlay.addEventListener("mouseleave", function () {
        this.classList.add("map--no-touch");
      });

      mapOverlay.addEventListener("click", function () {
        this.classList.remove("map--no-touch");
      });
    }
  }
});

let btnsShowAddressOnMap = Array.from(
  document.querySelectorAll("[data-map-address]")
);

function initSimpleMap(mapItem) {
  let mapCoords = mapItem.getAttribute("data-map-coords").split(",");
  let mapIcon = mapItem.getAttribute("data-map-icon");

  let myMap = new ymaps.Map(mapItem, {
    center: mapCoords,
    zoom: 17,
    controls: [],
  });

  addPointsToMap(myMap, mapIcon);
}

function addPointsToMap(yandexMap, mapIcon) {
  let pointsManager = new ymaps.ObjectManager();
  let coords = 0;

  ymaps.option.presetStorage.add("mypreset", {
    iconLayout: "default#image",
    iconImageHref: mapIcon,
    iconImageSize: [41, 46],
    iconImageOffset: [-20, -46],
  });

  btnsShowAddressOnMap.forEach((btn, i) => {
    let address = btn.dataset.mapAddress;

    if (i === 0) {
      btn.classList.add("active");
    }

    ymaps
      .geocode(address, {
        results: 1,
      })
      .then(function (res) {
        let firstGeoObject = res.geoObjects.get(0);
        coords = firstGeoObject.geometry.getCoordinates();

        if (i === 0) {
          setMapCenter(yandexMap, 15, coords);
        }

        pointsManager.add({
          type: "Feature",
          id: i,
          geometry: {
            type: "Point",
            coordinates: coords,
          },
          options: {
            iconLayout: "default#image",
            iconImageHref: mapIcon,
            iconImageSize: [41, 46],
            iconImageOffset: [-20, -46],
          },
        });
      });

    btn.addEventListener("click", () => {
      if (!btn.classList.contains("active")) {
        document
          .querySelector("[data-map-address].active")
          .classList.remove("active");
        btn.classList.add("active");
      }

      const pointCoordinates =
        pointsManager.objects.getById(i).geometry.coordinates;

      setMapCenter(yandexMap, 15, pointCoordinates);
    });
  });

  pointsManager.objects.events.add("click", function (e) {
    let objectId = e.get("objectId");

    if (!btnsShowAddressOnMap[objectId].classList.contains("active")) {
      btnsShowAddressOnMap[objectId].click();
    }
  });

  yandexMap.geoObjects.add(pointsManager);
}

function setMapCenter(yandexMap, mapZoom, pointCoordinatesArray) {
  yandexMap.setCenter(pointCoordinatesArray, mapZoom, { checkZoomRange: true });
}
