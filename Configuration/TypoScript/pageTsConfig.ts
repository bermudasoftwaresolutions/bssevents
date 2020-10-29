RTE.default.proc {
    allowTag := addToList(img)
    allowTagsOutside := addToList(img)
    entryHTMLparser_db.tags.img >
}
RTE.default.showButtons := addToList(image)
RTE.default.FE {
    proc.allowTags := RTE.default.proc.allowTags
proc.allowTagsOutside < RTE.default.proc.allowTagsOutside
proc.entryHTMLparser_db.tags.img >
showButtons < RTE.default.showButtons
}