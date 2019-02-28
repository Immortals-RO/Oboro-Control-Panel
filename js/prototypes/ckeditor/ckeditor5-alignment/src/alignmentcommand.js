/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md.
 */

/**
 * @module alignment/alignmentcommand
 */

import Command from '@ckeditor/ckeditor5-core/src/command';
import first from '@ckeditor/ckeditor5-utils/src/first';

/**
 * The alignment command plugin.
 *
 * @extends module:core/command~Command
 */
export default class AlignmentCommand extends Command {
	/**
	 * Creates an instance of the command.
	 *
	 * @param {module:core/editor/editor~Editor} editor The editor instance.
	 * @param {'left'|'right'|'center'|'justify'} type Alignment type to be handled by this command.
	 * @param {Boolean} isDefault Indicates if command is of default type.
	 */
	constructor( editor, type, isDefault ) {
		super( editor );

		/**
		 * The type of the list created by the command.
		 *
		 * @readonly
		 * @member {'left'|'right'|'center'|'justify'}
		 */
		this.type = type;

		/**
		 * Whether this command has default type.
		 *
		 * @readonly
		 * @private
		 * @member {Boolean}
		 */
		this._isDefault = isDefault;

		/**
		 * A flag indicating whether the command is active, which means that the selection starts in a block
		 * that has defined alignment of the same type.
		 *
		 * @observable
		 * @readonly
		 * @member {Boolean} #value
		 */
	}

	/**
	 * @inheritDoc
	 */
	refresh() {
		const firstBlock = first( this.editor.document.selection.getSelectedBlocks() );

		// As first check whether to enable or disable command as value will be always false if command cannot be enabled.
		this.isEnabled = !!firstBlock && this._canBeAligned( firstBlock );
		this.value = this._getValue( firstBlock );
	}

	/**
	 * Executes the command.
	 *
	 * @protected
	 * @param {Object} [options] Options for the executed command.
	 * @param {module:engine/model/batch~Batch} [options.batch] A batch to collect all the change steps.
	 * A new batch will be created if this option is not set.
	 */
	execute( options = {} ) {
		const editor = this.editor;
		const document = editor.document;

		document.enqueueChanges( () => {
			const batch = options.batch || document.batch();

			// Get only those blocks from selected that can have alignment set
			const blocks = Array.from( document.selection.getSelectedBlocks() ).filter( block => this._canBeAligned( block ) );

			// Remove alignment attribute if current alignment is as selected or is default one.
			// Default alignment should not be stored in model as it will bloat model data.
			if ( this.value || this._isDefault ) {
				removeAlignmentFromSelection( blocks, batch );
			} else {
				setAlignmentOnSelection( blocks, batch, this.type );
			}
		} );
	}

	/**
	 * Checks whether block can have aligned set.
	 *
	 * @param {module:engine/model/element~Element} block A block to be checked.
	 * @returns {Boolean}
	 * @private
	 */
	_canBeAligned( block ) {
		const schema = this.editor.document.schema;

		// Check if adding alignment attribute to selected block is allowed.
		return schema.check( {
			name: block.name,
			// Apparently I must pass current attributes as otherwise adding alignment on listItem will fail.
			attributes: [ ...block.getAttributeKeys(), 'alignment' ]
		} );
	}

	/**
	 * Checks the command's {@link #value}.
	 *
	 * @private
	 * @param {module:engine/model/element~Element} firstBlock A first block in selection to be checked.
	 * @returns {Boolean} The current value.
	 */
	_getValue( firstBlock ) {
		// The #_checkEnabled is checked as first so if command is disabled it's value is also false.
		if ( !this.isEnabled || !firstBlock ) {
			return false;
		}

		const selectionAlignment = firstBlock.getAttribute( 'alignment' );

		// Command's value will be set when commands type is matched in selection or the selection is default one.
		return selectionAlignment ? selectionAlignment === this.type : this._isDefault;
	}
}

// Removes alignment attribute from blocks.
// @private
function removeAlignmentFromSelection( blocks, batch ) {
	for ( const block of blocks ) {
		batch.removeAttribute( 'alignment', block );
	}
}

// Sets alignment attribute on blocks.
// @private
function setAlignmentOnSelection( blocks, batch, type ) {
	for ( const block of blocks ) {
		batch.setAttribute( 'alignment', type, block );
	}
}
