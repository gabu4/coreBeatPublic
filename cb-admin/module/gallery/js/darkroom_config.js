jQuery(document).ready(function() {
    callDarkroomJS();
});

var callDarkroomJS = function() {
    var imageWidth = jQuery("#target").width();
    var imageHeight = jQuery("#target").height();
    var dkrm = new Darkroom('#target', {
        // Size options
        minWidth: 100,
        minHeight: 100,
        maxWidth: imageWidth,
        maxHeight: imageWidth,
        backgroundColor: '#000',

        // Plugins options
        plugins: {
            //save: false,
            crop: {
                quickCropKey: 67, //key "c"
                //minHeight: 50,
                //minWidth: 50,
                //ratio: 4/3
            }
        },

        // Post initialize script
        initialize: function() {
            var cropPlugin = this.plugins['crop'];
            // cropPlugin.selectZone(170, 25, 300, 300);
            cropPlugin.requireFocus();
        }
    });
};
