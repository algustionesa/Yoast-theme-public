<div id="content">
	<div id="ais-wrapper">
		<aside id="ais-facets">
			<section class="ais-facets" id="facet-post-types"></section>
			<section class="ais-facets" id="facet-categories"></section>
			<section class="ais-facets" id="facet-users"></section>
		</aside>
		<main id="ais-main">

			<div id="algolia-hits"></div>
			<div id="algolia-pagination"></div>
		</main>

		<script type="text/html" id="tmpl-instantsearch-hit">
			<div class="result row">
				<h2 class="tight" itemprop="name headline">
					<a href="{{ data.permalink }}" title="{{ data.post_title }}" itemprop="url">
						{{{ data._highlightResult.post_title.value }}}
					</a>
				</h2>
				<div class="meta">
					<p class="ais-hits--tags">
						{{{data.post_modified_formatted}}}
						by
						<a href="{{{data.post_author.author_link}}}">
							{{{data.post_author.display_name}}}
						</a>
					</p>
					<# if (data.taxonomies.post_tag) { #>
						<p>
							<# for (var index in data.taxonomies.post_tag) { #>
								<span class="ais-hits--tag">{{{ data._highlightResult.taxonomies.post_tag[index].value }}}</span>
							<# } #>
						</p>
					<# } #>
				</div>

				<# if ( data.images.thumbnail || data.metadesc || data.excerpt ) { #>
					<div class="media media--nofloat">
						<# if ( data.images.thumbnail ) { #>
							<a href="{{{data.permalink}}}" class="imgExt">
								<img src="{{ data.images.thumbnail.url }}" class="ais-hits--thumbnail attachment-thumbnail-recent-articles size-thumbnail-recent-articles wp-post-image" width="250" height="131" alt="{{ data.post_title }}" title="{{ data.post_title }}"
								     itemprop="image"/>
							</a>
						<# } #>
						<article class="bd">
							<div class="metadesc">
								<# if(data.metadesc){ #>
									<p class="metadesc">{{{data.metadesc}}}</p>
								<# } else if(!data.metadesc && data.excerpt) { #>
									<p class="excerpt">{{{data.excerpt}}}</p>
								<# } #>
							</div>
						</article>
					</div>
				<# } #>
			</div>
			<hr class="hr--no-pointer">
		</script>


		<script type="text/javascript">
			jQuery( function() {
				if ( jQuery( '#algolia-search-box' ).length > 0 ) {

					if ( algolia.indices.searchable_posts === undefined && jQuery( '.admin-bar' ).length > 0 ) {
						alert( 'It looks like you haven\'t indexed the searchable posts index. Please head to the Indexing page of the Algolia Search plugin and index it.' );
					}

					// Instantiate instantsearch.js
					var search = instantsearch( {
						appId: algolia.application_id,
						apiKey: algolia.search_api_key,
						indexName: algolia.indices.searchable_posts.name,
						urlSync: {
							mapping: { 'q': 's' },
							trackedParameters: ['query']
						},
						searchParameters: {
							facetingAfterDistinct: true
						},
						searchFunction: function( helper ) {
							var savedPage = helper.state.page;
							if ( search.helper.state.query === '' ) {
								search.helper.setQueryParameter( 'distinct', false );
								search.helper.setQueryParameter( 'filters', 'record_index=0' );
							} else {
								search.helper.setQueryParameter( 'distinct', true );
								search.helper.setQueryParameter( 'filters', '' );
							}

							search.helper.setPage(savedPage);
							helper.search();
						}
					} );

					// Search box widget
					search.addWidget(
						instantsearch.widgets.searchBox( {
							container: '#algolia-search-box',
							placeholder: 'Search for...',
							wrapInput: false,
							poweredBy: algolia.powered_by_enabled
						} )
					);

					// Stats widget
					search.addWidget(
						instantsearch.widgets.stats( {
							container: '#algolia-stats'
						} )
					);

					// Hits widget
					search.addWidget(
						instantsearch.widgets.hits( {
							container: '#algolia-hits',
							hitsPerPage: 10,
							templates: {
								empty: 'No results were found for "<strong>{{query}}</strong>".',
								item: wp.template( 'instantsearch-hit' )
							}
						} )
					);

					// Pagination widget
					search.addWidget(
						instantsearch.widgets.pagination( {
							container: '#algolia-pagination'
						} )
					);

					// Post types refinement widget
					search.addWidget(
						instantsearch.widgets.refinementList( {
							container: '#facet-post-types',
							attributeName: 'post_type_label',
							operator: 'or',
							limit: 10,
							sortBy: ['count:desc', 'name:asc'],
							templates: {
								header: '<h3 class="widgettitle">Post types</h3>'
							},
							collapsible: true,
						} )
					);

					// Categories refinement widget
					search.addWidget(
						instantsearch.widgets.refinementList( {
							container: '#facet-categories',
							attributeName: 'taxonomies.category',
							operator: 'or',
							limit: 10,
							sortBy: ['count:desc', 'name:asc'],
							templates: {
								header: '<h3 class="widgettitle">Categories</h3>'
							},
							collapsible: true,
						} )
					);

					// Author refinement widget
					search.addWidget(
						instantsearch.widgets.refinementList( {
							container: '#facet-users',
							attributeName: 'post_author.display_name',
							operator: 'or',
							limit: 15,
							sortBy: ['count:desc', 'name:asc'],
							templates: {
								header: '<h3 class="widgettitle">Authors</h3>'
							},
							collapsible: true,
						} )
					);


					// Start
					search.start();

					jQuery( '#algolia-search-box input' ).attr( 'type', 'search' ).select();
				}
			} );
		</script>
	</div>
</div>
