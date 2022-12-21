class Message{
    constructor(source, destination, text, date){
        this.source = source;
        this.destination = destination;
        this.text = text;
        this.date = date;
    }

    getSource(){
        return this.source;
    }

    getDestination(){
        return this.destination;
    }

    getText(){
        return this.text;
    }

    getDate(){
        return this.date;
    }
}