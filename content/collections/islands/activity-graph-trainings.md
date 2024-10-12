---
id: 2c0a6270-f05f-46ee-b976-61121c2e297d
blueprint: island
title: activity-graph-trainings
updated_by: 225d58b0-3de7-45fb-b9a6-a2f543c6834c
updated_at: 1728761224
placeholder:
  code: |-
    <div slot="loading" hidden>
    <div class="skeleton" style="width:90%;"></div>
              <div class="skeleton" style="width:55%;"></div>
              <div class="skeleton" style="width:80%;"></div>
              <div class="skeleton" style="width:65%;"></div>
              <div class="skeleton" style="width:85%;"></div>
    		  </div>
  mode: handlebars
query_head: 'head > style'
body:
  code: |-
    <activity-graph
    	class="not-prose"
        range-start="2024-01-01"
        range-end="2024-12-31"
        activity-data="{{ aggregated_trainings }}"
        activity-levels="0,1,2"
    	i18n='{"less":"Less (0)","more":"More (>1)"}'
    	first-day-of-week="1"
    ></activity-graph>
  mode: handlebars
head:
  code: null
  mode: handlebars
lazy_loading: false
content:
  code: |-
    <activity-graph
    	class="not-prose"
        range-start="2024-01-01"
        range-end="2024-12-31"
        activity-data="{{ aggregated_trainings }}"
        activity-levels="0,1,2"
    	i18n='{"less":"Less (0)","more":"More (>1)"}'
    	first-day-of-week="1"
    ></activity-graph>
  mode: handlebars
---
