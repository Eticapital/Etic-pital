window.notify = function notify(body, type = 'success', showIcon = false, showCloseButton = true, title = '', duration = null, user = null) {
  let notification = {
    body: body,
    type: type,
    showCloseButton: showCloseButton,
    title: title,
    duration: duration,
    id: uniqid(),
    showIcon: showIcon,
  }

  Vue.nextTick(() => {
    bus.$emit('top-notification', notification);
  })
}

window.growl = function growl(body, type = 'success', showIcon = false, title = '', showCloseButton = true, duration = null, user = null) {
  let notification = {
    body: body,
    type: type,
    showCloseButton: showCloseButton,
    title: title,
    duration: duration,
    id: uniqid(),
    showIcon: showIcon,
  }
  return bus.$emit('growl-notification', notification);
}

String.prototype.slugify = function() { // <-- removed the argument
  var str = this; // <-- added this statement

  str = str.replace(/^\s+|\s+$/g, ''); // trim
  str = str.toLowerCase();

  // remove accents, swap ñ for n, etc
  var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
  var to   = "aaaaeeeeiiiioooouuuunc------";

  for (var i=0, l=from.length ; i<l ; i++)
    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));


  str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
    .replace(/\s+/g, '-') // collapse whitespace and replace by -
    .replace(/-+/g, '-'); // collapse dashes

  return str;
};


_.mixin({
  findDeep: function(items, attrs) {

    let path = []

    function match(value) {
        for (var key in attrs) {
            if (!_.isUndefined(value)) {
                if (attrs[key] !== value[key]){
                    return false;
                }
            }
        }
        return true;
    }

    function traverse(items, path) {
        if(item = _.find(items, function(item) {
            return match(item);
        }))  {
          return item;
        }

        return _.find(items, function(item) {
            if (!_.isUndefined(item.items)) {
              result = traverse(item.items, path)
              if (result) {
                return path.unshift(result);
                ;
              }
            }
        });

        return null;
    }

    var result = traverse(items, path);

    if (result) {
      path.unshift(result);
      return path;
    }

    return false;
  }
});