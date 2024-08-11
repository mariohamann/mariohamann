---
id: 2c0a6270-f05f-46ee-b976-61121c2e297d
blueprint: island
title: activity-graph-trainings
updated_by: 225d58b0-3de7-45fb-b9a6-a2f543c6834c
updated_at: 1722889276
placeholder:
  code: null
  mode: handlebars
query_head: 'head > style'
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
