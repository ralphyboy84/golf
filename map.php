<script>
async function getMe() {

const params = {
    "locations": [
        {
            "id": "location-1",
            "coords": {
                "lat": 51.508037,
                "lng": -0.1280494
            }
        },
        {
            "id": "location-2",
            "coords": {
                "lat": 51.5156177,
                "lng": -0.0919983
            }
        }
    ],
    "departure_searches": [
        {
            "properties": [
                "travel_time",
                "route"
            ],
            "transportation": {
                "type": "driving"
            },
            "id": "departure-search",
            "departure_location_id": "location-1",
            "arrival_location_ids": [
                "location-2"
            ],
            "departure_time": "2026-01-14T09:00:00Z"
        }
    ]
}

const resukt = await fetch("https://api.traveltimeapp.com/v4/routes")
}
    </script>