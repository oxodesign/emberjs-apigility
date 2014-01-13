App = Ember.Application.create({
    LOG_TRANSITIONS: true,
    LOG_VIEW_LOOKUPS: true
});

App.Router.map(function(){
    this.resource('todos', {path : '/'});
});

App.Adapter = DS.RESTAdapter.extend({
    namespace: "emberjs-apigility",

    createRecord: function(store, type, record) {
        var data = {};
        var serializer = store.serializerFor(type.typeKey);

        serializer.serializeIntoHash(data, type, record, { includeId: true });

        return this.ajax(this.buildURL(type.typeKey), "POST", { data: data[type.typeKey] });
    },

    updateRecord: function(store, type, record) {
        var data = {};
        var serializer = store.serializerFor(type.typeKey);

        serializer.serializeIntoHash(data, type, record);

        var id = Ember.get(record, 'id');


        return this.ajax(this.buildURL(type.typeKey, id), "PUT", { data: data[type.typeKey] });
    }
});

App.ApplicationSerializer = DS.ActiveModelSerializer.extend({
    primaryKey: 'todos_id',

    extract: function(store, type, payload, id, requestType) {
        this.extractMeta(store, type, payload);

        if(payload._embedded)
            payload = payload._embedded;

        if(requestType == 'updateRecord' || requestType == 'createRecord'){
            var data = {};
            data[type.typeKey] = payload;
            payload = data;
        }

        var specificExtract = "extract" + requestType.charAt(0).toUpperCase() + requestType.substr(1);
        return this[specificExtract](store, type, payload, id, requestType);
    }
});

App.Store = DS.Store.extend({
    adapter: App.Adapter
});



App.TodosRoute = Ember.Route.extend({
    model : function(){
        return this.store.find('todo');
    },

    actions : {
        add : function(){
            var self = this;
            var todo = this.store.createRecord('todo');

            todo.set('name', this.get('controller').get('todoName'));
            todo.set('isCompleted', false);

            todo.save().then(function(){
                self.get('controller').set('todoName', '');
                console.log('Todo added ...');
            });
        },

        delete : function(model){
            if (confirm("Are you sure you want to delete the selected record ? Click OK to continue.")) {
                //deletes record from store
                model.deleteRecord();

                //persist change
                model.save().then(function(){
                    console.log('Todo deleted');
                });
            }
        }
    }
});

App.Todo = DS.Model.extend({
    name: DS.attr('string'),
    isCompleted: DS.attr('boolean'),

    changeObserver: function(){
        if(this.get('isDirty') == true && !this.get('isNew')){
            this.save().then(function(){
                console.log('Model changed and saved!');
            });
        }
    }.observes('isCompleted')
});