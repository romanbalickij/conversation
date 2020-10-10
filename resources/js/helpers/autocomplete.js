import algolia from "algoliasearch";
import autocomplete from 'autocomplete.js'


var index = algolia('DP1DYMXZ21','fdba54e68ae962464d0e35caca63cdd1')


export const userautocomplete = selector => {

    var users = index.initIndex('users')


    function newHitsSource(index, params) {
        return function doSearch(query, cb) {
            index
                .search(query, params)
                .then(function(res) {
                    cb(res.hits, res);
                })
                .catch(function(err) {
                    console.error(err);
                    cb([]);
                });
        };
    }

   // return  autocomplete('#users', { hint: false }, [
   //      {
   //          source: newHitsSource(users, { hitsPerPage: 5 }),
   //          displayKey: 'name',
   //          templates: {
   //              suggestion: function(suggestion) {
   //                  return suggestion.name;
   //              }
   //          }
   //      }
   //  ]).on('autocomplete:selected', function(event, suggestion, dataset, context) {
   //      console.log(event, suggestion, dataset, context);
   //  });

    return autocomplete(selector, {}, {
        source: newHitsSource(users, { hitsPerPage: 10 }),
        displayKey: 'name',
        templates: {
            suggestion (suggestion) {
                return '<span>' + suggestion.name + '</span>'
            },
            empty: '<div class="aa-empty">No people found.</div>'
        }
    })
}
