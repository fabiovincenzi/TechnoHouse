export class Location{
    constructor(latitude, longitude){
        this.latitude = latitude;
        this.longitude = longitude;
    }

    getLocation(){
        const location = {
            "Latitude" : this.latitude,
            "Longitude" : this.longitude
        };
        return location;
    }
}