var createSeat = function(initialX, initialY, color) {
    var rect = new Kinetic.Rect({
      x: initialX,
      y: initialY,
      height: 30,
      width: 30,
      fill: color,
      stroke: "black",
      strokeWidth: 1
    });
    return rect;
};

var createDesk = function(paramX, paramY, paramRotation, name, leftseat, rightseat, leftseatavailable, rightseatavailable) {
    if (typeof(leftseat) === 'undefined') leftseat = false;
    if (typeof(rightseat) === 'undefined') rightseat = false;
    if (typeof(leftseatavailable) === 'undefined') leftseatavailable = false;
    if (typeof(rightseatavailable) === 'undefined') rightseatavailable = false;
    
    var desk = new Kinetic.Rect({
      name: "table",
      height: 80,
      width: 180,
      fill: "#00D2FF",
      stroke: "black",
      strokeWidth: 3
    });
    var group = new Kinetic.Group({
      height: 80,
      width: 180,
      x: paramX,
      y: paramY,
      rotation: paramRotation * Math.PI / 180
    });
    group.add(desk);

    var addStandardEventsToSeat = function(seatId, kineticRect) {
        kineticRect.on("click", function(e) {
            if(typeof group.seatOnMouseOver == 'function') {
                group.seatOnClick(seatId, kineticRect);
            }
        });
        kineticRect.on("mouseover", function(e) {
            if(typeof group.seatOnMouseOver == 'function') {
                group.seatOnMouseOver(seatId, kineticRect, e);
            }
        });
        kineticRect.on("mouseout", function(e) {
            if(typeof group.seatOnMouseOut == 'function') {
                group.seatOnMouseOut(seatId, kineticRect);
            }
        });
    };
    
    group.leftseat = leftseat; // reinmergen
    if (leftseat != false) {
        if (leftseatavailable != false) {
            var color = "green";
        } else {
            var color = "red";
        }
        var leftSeat = createSeat(30, 23, color);
        group.add(leftSeat);
        addStandardEventsToSeat(group.leftseat, leftSeat);
    }
    group.rightseat = rightseat; // reinmergen
    if (rightseat != false) {
        if (rightseatavailable != false) {
            var color = "green";
        } else {
            var color = "red";
        }
        var rightSeat = createSeat(120, 23, color);
        group.add(rightSeat);
        addStandardEventsToSeat(group.rightseat, rightSeat);
    }
    
    group.setName(name);
    return group;
};